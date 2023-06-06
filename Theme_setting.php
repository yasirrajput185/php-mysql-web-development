<!-- Theme_setting -->
<?php
include("require/header.php");
include("database/connection.php");

?>
<div class="container">
    <div class="card my-5">
        <div class="card-header bg-dark text-white">
            <h2>Post Customize Theme (NOT FUNCTIONAL)</h2>
        </div>
        <div class="card-body">
        <form method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col">
                        <label for="bgcolor" class="form-label">Choose Background Color</label>
                        <input type="color" class="form-control" id="bgcolor" name="bgcolor" required>
                    </div>
                </div>
                <div class="mb-3">
                        <label for="font_size" class="form-label">Font Size</label>
                        <input type="text" class="form-control" id="font_size" name="font_size" required>
                    </div>

                <div class="mb-3">
                    <label for="font_style" class="form-label">Font Style</label>
                    <select class="form-select" id="font_style" name="font_style" required>
                        <option value="">Select Font Style</option>
                        <option value="cursive" style="font-family: cursive;">Cursive</option>
                        <option value="female" style="font-family: serif;">Serif</option>
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>

    </div>
    </form>
  </div>
</div>
</div>

<script type="text/javascript" src="require/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
