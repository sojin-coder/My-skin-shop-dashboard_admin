<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #c9cacc;
            padding: 40px 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        h2{
            text-align: center;
        }

        .back {
            display: inline-block;
            margin-bottom: 25px;
            color: #3b82f6;
            text-decoration: none;
        }

        .product {
            display: flex;
            gap: 35px;
        }

        .image {
            width: 350px;
        }

        .image img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .info {
            flex: 1;
        }

        .info h1 {
            font-size: 30px;
            margin-bottom: 15px;
            color: #1a252f;
        }

        .description {
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .price {
            font-size: 25px;
            font-weight: 600;
            color: #10b981;
            margin-bottom: 15px;
        }

        .stock {
            color: #475569;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="container">
    <h2 >Product Details</h2>

    <a href="<?= BASE_URL ?>/" class ="back">  Back to List</a>

    <div class="product">

        <div class="image">
            <?php if (!empty($product['image'])): ?>

                <img
                    src="<?= BASE_URL ?>/assets/uploads/<?= htmlspecialchars($product['image']) ?>"
                    alt="<?= htmlspecialchars($product['name']) ?>"
                >

            <?php else: ?>

                <p>No Image</p>

            <?php endif; ?>
        </div>

        <div class="info">

            <h1>
                <?= htmlspecialchars($product['name']) ?>
            </h1>

            <p class="description">
                <?= htmlspecialchars($product['description'] ?? '') ?>
            </p>

            <div class="price">
                $<?= number_format($product['price'], 2) ?>
            </div>

            <div class="stock">
                Stock:
                <?= htmlspecialchars($product['stock']) ?>
            </div>

        </div>

    </div>

</div>

</body>
</html>