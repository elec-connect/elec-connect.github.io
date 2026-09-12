<?php
// ============================================
// PROXY SÉCURISÉ POUR GEMINI - ELEC-CONNECT
// ============================================
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: https://elec-connect.tn');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('X-Content-Type-Options: nosniff');

// Gestion du preflight CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// ============================================
// CONFIGURATION
// ============================================
$API_KEY = 'AQ.Ab8RN6LFMDOjio5vLZbL3vYEMWYooiyhzDAM7DKKF4YH8SqTOA';
$MODEL   = 'gemini-1.5-flash'; // ou gemini-1.5-flash

// Récupération du message
$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);
$userMessage = trim($input['message'] ?? '');

if (empty($userMessage)) {
    http_response_code(400);
    echo json_encode(['error' => 'Message vide']);
    exit;
}

// Limite anti-abus
if (mb_strlen($userMessage) > 500) {
    $userMessage = mb_substr($userMessage, 0, 500);
}

$systemPrompt = <<<PROMPT
Tu es l'assistant virtuel d'Elec-Connect, entreprise tunisienne de domotique et électricité intelligente à Jemmel (5020), Tunisie.

## INFORMATIONS OFFICIELLES
- Téléphone : +216 29 328 870
- Email : Iot.sahnoun@gmail.com
- Adresse : 01, Rue Manfalouti, Jemmel 5020, Tunisie
- Marques : Schneider Electric, Legrand, Somfy, Sonoff
- Services : installation domotique, électricité intelligente, maintenance, conseil, devis gratuit
- Délai : 2 à 5 jours selon le projet
- Zone : toute la Tunisie
- Offre actuelle : -15% jusqu'au 31/03

## TA MISSION
Comprendre le SENS des messages, pas seulement les mots exacts.
L'utilisateur peut écrire :
- En français (avec fautes, abréviations, argot)
- En arabe standard
- En darija tunisienne (translittérée OU en caractères arabes)
- En mélangeant plusieurs langues
- Avec des fautes d'orthographe ou abréviations SMS

## EXEMPLES DE COMPRÉHENSION SÉMANTIQUE
- "bch n3amel dar we7la" → projet de maison intelligente
- "chnowa el aswem" → question sur les tarifs
- "n7eb na3ref kifech nkalmekoum" → veut vos coordonnées
- "3andkom installation fi sousse ?" → intervention géographique
- "9adeh tekhou 3al installation" → tarif d'installation
- "fammech promos" → question sur les offres

## RÈGLES DE RÉPONSE
1. **LANGUE DE RÉPONSE = LANGUE DU MESSAGE** :
   - Français → français
   - Arabe standard → arabe standard
   - Darija → darija avec caractères arabes
   - Mélange → darija (langue la plus utilisée en Tunisie)

2. **STYLE** : court (2-3 phrases), chaleureux, 1 emoji max, professionnel.

3. **FORMATAGE** : utilise <br> pour les sauts de ligne.

4. **NUMÉROS** : toujours écrire les numéros de téléphone en format international : +216 29 328 870

5. **SI INCERTAIN** : propose d'appeler le +216 29 328 870.

6. **INTERDIT** : ne parle JAMAIS de sujets hors domotique, électricité, ou Elec-Connect.
PROMPT;

// ============================================
// APPEL À L'API GEMINI
// ============================================
$url = "https://generativelanguage.googleapis.com/v1beta/models/{$MODEL}:generateContent?key={$API_KEY}";

$payload = [
    'contents' => [
        [
            'role' => 'user',
            'parts' => [
                ['text' => $systemPrompt . "\n\n---\n\nMessage du client : " . $userMessage]
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.7,
        'maxOutputTokens' => 400,
        'topP' => 0.95,
    ],
    'safetySettings' => [
        ['category' => 'HARM_CATEGORY_HARASSMENT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
        ['category' => 'HARM_CATEGORY_HATE_SPEECH', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
        ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
        ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
    ]
];

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
    CURLOPT_TIMEOUT        => 25,
    CURLOPT_SSL_VERIFYPEER => true,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = curl_error($ch);
curl_close($ch);

if ($curlErr) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur réseau: ' . $curlErr]);
    exit;
}

if ($httpCode !== 200) {
    http_response_code(502);
    echo json_encode([
        'error' => 'Erreur API Gemini',
        'code'  => $httpCode,
        'details' => json_decode($response, true)
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$result = json_decode($response, true);
$botReply = $result['candidates'][0]['content']['parts'][0]['text']
          ?? "Désolé, je n'ai pas pu répondre. Appelez-nous au +216 29 328 870.";

echo json_encode([
    'reply' => $botReply,
    'model' => $MODEL
], JSON_UNESCAPED_UNICODE);
