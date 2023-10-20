<?php include('./layout/head.php')    ?>
<?php include('./layout/header.php')    ?>
<!-- Header Top END ==== -->
<!-- Content -->
<?php include('./layout/slider.php')    ?>

<div class="container">
    <h2>Courses</h2>
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
            <table class="table table-card table-sm mb-0">
                <thead class="bg-light border-top">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Credit Hours</th>
                        <th>Section</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody id="data" class="font-12"></tbody>
            </table>
        </div>
    </div>
</div>

<script src="modules/courses/js/data.js"></script>
<?php include('./layout/footer.php')    ?>