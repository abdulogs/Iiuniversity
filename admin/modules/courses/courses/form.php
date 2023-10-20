<?php
require_once "../../../../classes/crud.php";

if (!isset($_POST) and $_SERVER['REQUEST_METHOD'] !== "POST") {
  echo "Request failed";
} elseif (empty($_POST['id'])) { ?>

  <form class="modal-content border-0 shadow-lg" method="post" id="create">
    <div class="modal-header d-flex align-items-center align-middle p-2">
      <h5 class="modal-title font-20 m-0">
        <b><span class="fa fa-plus-circle mr-2 font-20 text-success"></span>CREATE</b>
      </h5>
      <button class="btn btn-icon waves-effect waves-light text-dark btn-sm" data-dismiss="modal" aria-label="Close">
        <i class="fa fa-close"></i>
      </button>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="id">ID</label>
          <input class="form-control font-12" type="text" id="id" name="id" />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="name">Name</label>
          <input class="form-control font-12" id="name" name="name" type="text" required />
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="hours">Credit hours</label>
          <input class="form-control font-12" id="hours" name="hours" type="text" required />
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="section">Section</label>
          <input class="form-control font-12" id="section" name="section" type="text" required />
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="department">Department</label>
          <select class="custom-select font-12" id="department" name="department" required>
            <option value="">Select</option>
            <?php
            $departments = crud::select()::columns(["DeptID", "Name"])::table("department")::execute();
            $departments = crud::fetch("all");
            if ($departments) {
              foreach ($departments as $department) { ?>
                <option value="<?php echo $department["DeptID"] ?>"><?php echo $department["Name"] ?></option>
            <?php }
            } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="modal-footer bg-light">
      <button class="btn btn-light border btn-sm" type="button" data-dismiss="modal">Close</button>
      <button class="btn btn-success btn-sm btn-submit" id="btn-submit" type="submit">Proceed</button>
    </div>
  </form>
<?php } ?>


<?php
if (!empty($_POST['id'])) {
  $id = htmlentities(htmlspecialchars(strip_tags($_POST['id'])));
  $course = crud::select()::columns(["CourseID", "Section", "Title", "CreditHours", "DeptID"]);
  $course = crud::table("courses")::where(["CourseID" => $id])::execute();
  $course = crud::fetch("one");

  if ($course) { ?>
    <form class="modal-content border-0 shadow-lg" id="update">
      <div class="modal-header d-flex align-items-center align-middle p-2">
        <h5 class="modal-title font-20 m-0">
          <b><span class="fa fa-plus-circle mr-2 font-20 text-success"></span>UPDATE</b>
        </h5>
        <button class="btn btn-icon waves-effect waves-light text-dark btn-sm" data-dismiss="modal" aria-label="Close">
          <i class="fa fa-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="id">ID</label>
            <input class="form-control font-12" type="text" value="<?php echo $course['CourseID'] ?>" disabled />
            <input name="id" type="hidden" value="<?php echo $course['CourseID'] ?>" />
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="name">Title</label>
            <input class="form-control font-12" id="name" name="name" type="text" value="<?php echo $course['Title'] ?>" required />
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="hours">Credit Hours</label>
            <input class="form-control font-12" id="hours" name="hours" type="text" value="<?php echo $course['CreditHours'] ?>" required />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="section">Section</label>
            <input class="form-control font-12" id="section" name="section" type="text" value="<?php echo $course['Section'] ?>" required />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="department">Department</label>
            <select class="custom-select font-12" id="department" name="department" required>
              <option value="">Select</option>
              <?php
              $departments = crud::select()::columns(["DeptID", "Name"])::table("department")::execute();
              $departments = crud::fetch("all");
              if ($departments) {
                foreach ($departments as $department) { ?>
                  <option <?php echo ($department["DeptID"] == $course["DeptID"]) ? "selected" : ""; ?> value="<?php echo $department["DeptID"] ?>"><?php echo $department["Name"] ?></option>
              <?php }
              } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button class="btn btn-light border btn-sm" type="button" data-dismiss="modal">Close</button>
        <button class="btn btn-success btn-sm btn-submit" id="btn-submit" type="submit">Proceed</button>
      </div>
    </form>
<?php }
} ?>