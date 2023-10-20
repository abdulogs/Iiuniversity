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
          <label class="font-weight-bolder mb-0" for="id">Prerequsite</label>
          <select class="custom-select font-12" id="id" name="id" required>
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
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="grade">Grade</label>
          <input class="form-control font-12" id="grade" name="grade" type="text" required />
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
  $prerequsite = crud::select()::columns(["p.PreReqID", "c.Title", "cp.Title as course", "p.MinGrade"]);
  $prerequsite = crud::table("prerequsite as p");
  $prerequsite = crud::join(["courses AS cp" => ["cp.CourseID" => "p.PreReqID"]], "LEFT");
  $prerequsite = crud::join(["courses AS c" => ["c.CourseID" => "p.CourseID"]], "LEFT");
  $prerequsite = crud::where(["p.PreReqID" => $id])::execute();
  $prerequsite = crud::fetch("one");

  if ($prerequsite) { ?>
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
            <label class="font-weight-bolder mb-0" for="id">Prerequsite</label>
            <select class="custom-select font-12" id="id" name="id" required>
              <option value="">Select</option>
              <option selected value="<?php echo $prerequsite["PreReqID"] ?>">
                <?php echo $prerequsite["course"]; ?>
              </option>
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
                  <option <?php echo ($course["CourseID"] == $prerequsite["PreReqID"]) ? "selected" : ""; ?> value="<?php echo $course["CourseID"] ?>"><?php echo $course["Title"]; ?></option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="grade">Grade</label>
            <input class="form-control font-12" id="grade" name="grade" type="text" value="<?php echo $prerequsite["MinGrade"] ?>" required />
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