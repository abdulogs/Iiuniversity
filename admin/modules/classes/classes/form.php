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
          <input class="form-control font-12" id="id" name="id" type="text" required />
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="faculty">Faculty</label>
          <select class="custom-select font-12" id="faculty" name="faculty" required>
            <option value="">Select</option>
            <?php
            $users = crud::select()::columns(["UserID", "F_Name", "L_Name"])::table("users")::where(["UserType" => "Faculty"])::execute();
            $users = crud::fetch("all");
            if ($users) {
              foreach ($users as $user) { ?>
                <option value="<?php echo $user["UserID"] ?>">
                  <?php echo ucFirst($user["F_Name"]) . " " . ucFirst($user["L_Name"]); ?>
                </option>
            <?php }
            } ?>
          </select>
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="room">Room</label>
          <select class="custom-select font-12" id="room" name="room" required>
            <option value="">Select</option>
            <?php
            $rooms = crud::select()::columns(["RoomID", "RoomNumber", "RoomType"])::table("room");
            $rooms = crud::execute();
            $rooms = crud::fetch("all");
            if ($rooms) {
              foreach ($rooms as $room) { ?>
                <option value="<?php echo $room["RoomID"] ?>">
                  <?php echo $room["RoomNumber"] . " - " . $room["RoomType"]; ?>
                </option>
            <?php }
            } ?>
          </select>
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="semester">Semester</label>
          <select class="custom-select font-12" id="semester" name="semester" required>
            <option value="">Select</option>
            <?php
            $semesters = crud::select()::columns(["SemesterID", "SemesterName", "Year"])::table("semesteryear");
            $semesters = crud::execute();
            $semesters = crud::fetch("all");
            if ($semesters) {
              foreach ($semesters as $semester) { ?>
                <option value="<?php echo $semester["SemesterID"] ?>">
                  <?php echo $semester["SemesterName"] . " " . $semester["Year"]; ?>
                </option>
            <?php }
            } ?>
          </select>
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="timing">Timing</label>
          <select class="custom-select font-12" id="timing" name="timing" required>
            <option value="">Select</option>
            <?php
             $timings = crud::select();
             $timings = crud::columns(["t.TimeslotID", "t.PeriodID", "d.DayOfWeek", "p.Start_Time", "p.End_Time"]);
             $timings = crud::table("timeslot as t");
             $timings = crud::join(["day AS d" => ["d.DayID" => "t.DayID"]], "LEFT");
             $timings = crud::join(["period AS p" => ["p.PeriodID" => "t.PeriodID"]], "LEFT");
             $timings = crud::execute();
             $timings = crud::fetch("all");
            if ($timings) {
              foreach ($timings as $timing) { ?>
                <option value="<?php echo $timing["TimeslotID"] ?>">
                <?php echo $timing["Start_Time"] . " - " . $timing["Start_Time"] . " - " . $timing["DayOfWeek"]; ?>
                </option>
            <?php }
            } ?>
          </select>
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="course">Course</label>
          <select class="custom-select font-12" id="course" name="course" required>
            <option value="">Select</option>
            <?php
            $courses = crud::select()::columns(["CourseID", "Title"])::table("courses");
            $courses = crud::execute();
            $courses = crud::fetch("all");
            if ($courses) {
              foreach ($courses as $course) { ?>
                <option value="<?php echo $course["CourseID"] ?>"><?php echo $course["Title"]; ?>
                </option>
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
  $class = crud::select();
  $class = crud::columns(["CRN", "FacultyID", "RoomID", "SemesterID", "TimeslotID", "CourseID"]);
  $class = crud::table("class")::where(["CRN" => $id])::execute();
  $class = crud::fetch("one");

  if ($class) { ?>
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
            <input class="form-control font-12" type="text" value="<?php echo $class['CRN'] ?>" disabled />
            <input name="id" type="hidden" value="<?php echo $class['CRN'] ?>" required />
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="faculty">Faculty</label>
            <select class="custom-select font-12" id="faculty" name="faculty" required>
              <option value="">Select</option>
              <?php
              $users = crud::select()::columns(["UserID", "F_Name", "L_Name"])::table("users")::where(["UserType" => "Faculty"])::execute();
              $users = crud::fetch("all");
              if ($users) {
                foreach ($users as $user) { ?>
                  <option <?php echo ($user["UserID"] == $class["FacultyID"]) ? "selected" : ""; ?> value="<?php echo $user["UserID"] ?>">
                    <?php echo ucFirst($user["F_Name"]) . " " . ucFirst($user["L_Name"]); ?>
                  </option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="room">Room</label>
            <select class="custom-select font-12" id="room" name="room" required>
              <option value="">Select</option>
              <?php
              $rooms = crud::select()::columns(["RoomID", "RoomNumber", "RoomType"])::table("room");
              $rooms = crud::execute();
              $rooms = crud::fetch("all");
              if ($rooms) {
                foreach ($rooms as $room) { ?>
                  <option <?php echo ($room["RoomID"] == $class["RoomID"]) ? "selected" : ""; ?> value="<?php echo $room["RoomID"] ?>">
                    <?php echo $room["RoomNumber"] . " - " . $room["RoomType"]; ?>
                  </option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="semester">Semester</label>
            <select class="custom-select font-12" id="semester" name="semester" required>
              <option value="">Select</option>
              <?php
              $semesters = crud::select()::columns(["SemesterID", "SemesterName", "Year"])::table("semesteryear");
              $semesters = crud::execute();
              $semesters = crud::fetch("all");
              if ($semesters) {
                foreach ($semesters as $semester) { ?>
                  <option <?php echo ($semester["SemesterID"] == $class["SemesterID"]) ? "selected" : ""; ?> value="<?php echo $semester["SemesterID"] ?>">
                    <?php echo $semester["SemesterName"] . " " . $semester["Year"]; ?>
                  </option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="timing">Timing</label>
            <select class="custom-select font-12" id="timing" name="timing" required>
              <option value="">Select</option>
              <?php
              $timings = crud::select();
              $timings = crud::columns(["t.TimeslotID", "t.PeriodID", "d.DayOfWeek", "p.Start_Time", "p.End_Time"]);
              $timings = crud::table("timeslot as t");
              $timings = crud::join(["day AS d" => ["d.DayID" => "t.DayID"]], "LEFT");
              $timings = crud::join(["period AS p" => ["p.PeriodID" => "t.PeriodID"]], "LEFT");
              $timings = crud::execute();
              $timings = crud::fetch("all");
              if ($timings) {
                foreach ($timings as $timing) { ?>
                  <option <?php echo ($timing["TimeslotID"] == $class["TimeslotID"]) ? "selected" : ""; ?> value="<?php echo $timing["TimeslotID"] ?>">
                    <?php echo $timing["Start_Time"] . " - " . $timing["Start_Time"] . " - " . $timing["DayOfWeek"]; ?>
                  </option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="course">Course</label>
            <select class="custom-select font-12" id="course" name="course" required>
              <option value="">Select</option>
              <?php
              $courses = crud::select()::columns(["CourseID", "Title"])::table("courses");
              $courses = crud::execute();
              $courses = crud::fetch("all");
              if ($courses) {
                foreach ($courses as $course) { ?>
                  <option <?php echo ($course["CourseID"] == $class["CourseID"]) ? "selected" : ""; ?> value="<?php echo $course["CourseID"] ?>"><?php echo $course["Title"]; ?>
                  </option>
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