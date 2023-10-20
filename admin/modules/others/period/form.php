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
          <input class="form-control  font-12" id="id" name="id" type="text" required />
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="start">Start time</label>
          <input class="form-control font-12" id="start" name="start" type="time" required />
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="end">End time</label>
          <input class="form-control font-12" id="end" name="end" type="time" required />
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
  $period = crud::select()::columns(["PeriodID", "Start_Time", "End_Time"])::table("period");
  $period = crud::where(["PeriodID" => $id])::execute();
  $period = crud::fetch("one");

  if ($period) { ?>
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
            <input class="form-control  font-12" type="text" value="<?php echo $period['PeriodID'] ?>" disabled />
            <input name="id" type="hidden" value="<?php echo $period['PeriodID'] ?>" />
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="start">Start time</label>
            <input class="form-control font-12" id="start" name="start" type="time" value="<?php echo date('H:i:s', strtotime($period['Start_Time'])) ?>" required />
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="end">End time</label>
            <input class="form-control font-12" id="end" name="end" type="time" value="<?php echo date('H:i:s', strtotime($period['End_Time'])) ?>" required />
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