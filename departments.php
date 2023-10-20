<?php include('./layout/head.php')    ?>
<?php include('./layout/header.php')    ?>
<!-- Header Top END ==== -->
<!-- Content -->
<?php include('./layout/slider.php')    ?>

<div class="container">
    <h2>Departments</h2>
    <div class="row">
        <!-- <div class="col-md-5 col-md-5">
            <select name="">
                <option selected>Select Semester</option>
                <option value="">3</option>
                <option value="">4</option>
                <option value="">5</option>
            </select>
        </div>
        <div class="col-md-3 col-md-3">
            <input type="submit" name="btn" value="Search">
        </div> -->
        <div class="table-responsive col-12 mb-5 mt-4">
            <table class="table table-card table-sm mb-0 font-12">
                <thead class="bg-light border-top">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Chairman</th>
                        <th>Manager</th>
                        <th>Room</th>
                    </tr>
                </thead>
                <tbody id="data" class="font-12"></tbody>
            </table>
        </div>
    </div>
</div>

<script src="modules/departments/js/data.js"></script>
<?php include('./layout/footer.php')    ?>