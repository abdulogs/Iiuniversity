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
        <div class="form-group col-sm-2 mb-2">
          <label class="font-weight-bolder mb-0" for="name">Name</label>
          <input class="form-control font-12" id="name" name="name" type="text" required />
        </div>
        <div class="form-group col-sm-2 mb-2">
          <label class="font-weight-bolder mb-0" for="year">Year</label>
          <input class="form-control font-12" id="year" name="year" type="text" required />
        </div>
        <div class="form-group col-sm-4 mb-4">
          <label class="font-weight-bolder mb-0" for="start">Start date</label>
          <input class="form-control font-12" id="start" name="start" type="date" required />
        </div>
        <div class="form-group col-sm-4 mb-4">
          <label class="font-weight-bolder mb-0" for="end">End date</label>
          <input class="form-control font-12" id="end" name="end" type="date" required />
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="grade">Grading Time</label>
          <input class="form-control font-12" id="grade" name="grade" type="date" required />
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="reg">Registeration Time</label>
          <input class="form-control font-12" id="reg" name="reg" type="date" required />
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="drop">Drop Course Time</label>
          <input class="form-control font-12" id="drop" name="drop" type="date" required />
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
  $semester = crud::select()::columns(["SemesterID", "SemesterName", "Year", "StartDate", "EndDate"]);
  $semester = crud::columnsmore(["grade_time", "reg_time", "drop_time"]);
  $semester = crud::table("semesteryear")::where(["SemesterID" => $id])::execute();
  $semester = crud::fetch("one");

  if ($semester) { ?>
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
          <input id="id" name="id" type="hidden" value="<?php echo $semester['SemesterID'] ?>" required />
          <div class="form-group col-sm-2 mb-2">
            <label class="font-weight-bolder mb-0" for="name">Name</label>
            <input class="form-control font-12" id="name" name="name" type="text" value="<?php echo $semester['SemesterName'] ?>" required />
          </div>
          <div class="form-group col-sm-2 mb-2">
            <label class="font-weight-bolder mb-0" for="year">Year</label>
            <input class="form-control font-12" id="year" name="year" type="text" value="<?php echo $semester['Year'] ?>" required />
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="start">Start date</label>
            <input class="form-control font-12" id="start" name="start" type="date" value="<?php echo date('Y-m-d', strtotime($semester['StartDate'])) ?>" required />
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="end">End date</label>
            <input class="form-control font-12" id="end" name="end" type="date" value="<?php echo date('Y-m-d', strtotime($semester['EndDate'])) ?>" required />
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="grade">Grading Time</label>
            <input class="form-control font-12" id="grade" name="grade" type="date" value="<?php echo date('Y-m-d', strtotime($semester['grade_time'])) ?>" required />
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="reg">Registeration Time</label>
            <input class="form-control font-12" id="reg" name="reg" type="date" value="<?php echo date('Y-m-d', strtotime($semester['reg_time'])) ?>" required />
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="drop">Drop Course Time</label>
            <input class="form-control font-12" id="drop" name="drop" type="date" value="<?php echo date('Y-m-d', strtotime($semester['drop_time'])) ?>" required />
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