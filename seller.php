<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - E-Waste Submission</title>
    <link rel="stylesheet" href="sell.css">
</head>
<body>
    <div class="seller-container">
        <h1>Submit Your E-Waste</h1>
        
        <form id="ewasteForm" action="process_ewaste.php" method="POST">
            <!-- E-Waste Type Selection -->
            <div class="form-group">
                <label for="ewasteType">Type of E-Waste:</label>
                <select id="ewasteType" name="ewasteType" required>
                    <option value="" disabled selected>Select a category</option>
                    <option value="laptops">Laptops/Notebooks</option>
                    <option value="smartphones">Smartphones/Tablets</option>
                    <option value="desktops">Desktop Computers</option>
                    <option value="tv_monitors">TVs/Monitors</option>
                    <option value="printers">Printers/Scanners</option>
                    <option value="batteries">Batteries</option>
                    <option value="cables">Cables/Accessories</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <!-- Quantity Input -->
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <div class="quantity-selector">
                    <input type="number" id="quantity" name="quantity" min="1" required>
                    <select id="unit" name="unit">
                        <option value="pieces">Pieces</option>
                        <option value="kg">Kilograms</option>
                    </select>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="form-group">
                <label for="contact">Contact Number:</label>
                <input type="tel" id="contact" name="contact" pattern="[0-9]{10}" placeholder="10-digit number" required>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label for="address">Collection Address:</label>
                <textarea id="address" name="address" rows="4" required></textarea>
            </div>

            <!-- Additional Notes -->
            <div class="form-group">
                <label for="notes">Additional Notes (Optional):</label>
                <textarea id="notes" name="notes" rows="2" placeholder="E.g., Working condition, special handling instructions"></textarea>
            </div>

            <!-- Submission -->
            <button type="submit" class="submit-btn">Submit E-Waste</button>
        </form>
    </div>

    <div class="bottom">
        <div class="bottom-btn progress" ><a href="s_progress.php">Progress</a></div>
        <div class="bottom-btn log-out"><a href="logout.php">Logout</a></div>
    </div>

</body>
</html>