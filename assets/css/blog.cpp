/* Blog Container */
        .blog-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .blog-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .blog-header h1 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .blog-header p {
            font-size: 1.2rem;
            color: #7f8c8d;
        }

        /* Blog Grid */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        /* Blog Card */
        .blog-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .card-header {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .card-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .blog-card:hover .card-header img {
            transform: scale(1.1);
        }

        .category-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #4a6fa5;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .category-tag.green {
            background: #27ae60;
        }

        .category-tag.red {
            background: #e74c3c;
        }

        .category-tag.blue {
            background: #3498db;
        }

        .card-body {
            padding: 20px;
        }

        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: #7f8c8d;
        }

        .meta-info span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .card-body h2 {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: #2c3e50;
            line-height: 1.4;
        }

        .card-body p {
            color: #7f8c8d;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .read-more {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #4a6fa5;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s;
        }

        .read-more:hover {
            color: #2c3e50;
        }

        .card-footer {
            padding: 15px 20px;
            border-top: 1px solid #ecf0f1;
        }

        .share-buttons {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .share-buttons span {
            font-size: 0.9rem;
            color: #7f8c8d;
        }

        .share-buttons a {
            color: #7f8c8d;
            transition: color 0.3s;
        }

        .share-buttons a:hover {
            color: #4a6fa5;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 50px;
        }

        .page-btn, .page-num {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .page-btn {
            background: #f8f9fa;
            color: #4a6fa5;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .page-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .page-btn:not(.disabled):hover {
            background: #4a6fa5;
            color: white;
            border-color: #4a6fa5;
        }

        .page-num {
            color: #7f8c8d;
            border: 1px solid #ddd;
        }

        .page-num.active {
            background: #4a6fa5;
            color: white;
            border-color: #4a6fa5;
        }

        .page-num:not(.active):hover {
            background: #f8f9fa;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .blog-header h1 {
                font-size: 2rem;
            }
            
            .blog-grid {
                grid-template-columns: 1fr;
            }
            
            .pagination {
                flex-wrap: wrap;
            }
        }