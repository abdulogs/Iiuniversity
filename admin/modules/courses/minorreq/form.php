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
      <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="id">ID</label>
          <input class="form-control font-12" type="text" id="id" name="id" />
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="minor">Minor</label>
          <select class="custom-select font-12" id="minor" name="minor" required>
            <option value="">Select</option>
            <?php
            $minors = crud::select()::columns(["MinorID", "Name"])::table("minor")::execute();
            $minors = crud::fetch("all");
            if ($minors) {
              foreach ($minors as $minor) { ?>
                <option value="<?php echo $minor["MinorID"] ?>"><?php echo $minor["Name"]; ?></option>
            <?php }
            } ?>
          </select>
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="course">Course</label>
          <select class="custom-select font-12" id="course" name="course" required>
            <option value="">Select</option>
            <?php
            $courses = crud::select()::columns(["CourseID", "Title"])::table("courses")::execute();
            $courses = crud::fetch("all");
            if ($courses) {
              foreach ($courses as $course) { ?>
                <option value="<?php echo $course["CourseID"] ?>"><?php echo $course["Title"]; ?></option>
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
  $minor = crud::select()::columns(["MinorReqID", "MinorID", "CourseID"])::table("minor_req");
  $minor = crud::where(["MinorReqID" => $id])::execute();
  $minor = crud::fetch("one");

  if ($minor) { ?>
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
            <input class="form-control font-12" type="text" value="<?php echo $minor['MinorReqID']; ?>" disabled />
            <input name="id" type="hidden" value="<?php echo $minor['MinorReqID']; ?>" />
          </div>
         
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="minor">Minor</label>
            <select class="custom-select font-12" id="minor" name="minor" required>
              <option value="">Select</option>
              <?php
              $minors = crud::select()::columns(["MinorID", "Name"])::table("minor")::execute();
              $minors = crud::fetch("all");
              if ($minors) {
                foreach ($minors as $minorr) { ?>
                  <option <?php echo ($minorr["MinorID"] == $minor["MinorID"]) ? "selected" : ""; ?> value="<?php echo $minorr["MinorID"] ?>"><?php echo $minorr["Name"]; ?></option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="course">Course</label>
            <select class="custom-select font-12" id="course" name="course" required>
              <option value="">Select</option>
              <?php
              $courses = crud::select()::columns(["CourseID", "Title"])::table("courses")::execute();
              $courses = crud::fetch("all");
              if ($courses) {
                foreach ($courses as $course) { ?>
                  <option <?php echo ($course["CourseID"] == $minor["CourseID"]) ? "selected" : ""; ?> value="<?php echo $course["CourseID"] ?>"><?php echo $course["Title"]; ?></option>
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