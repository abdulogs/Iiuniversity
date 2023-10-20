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
          <input class="form-control font-12" name="id" id="id" type="text" required />
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="day">Day</label>
          <select class="custom-select shadow-none font-12" id="day" name="day" required>
            <option value="">Select</option>
            <?php
            $days = crud::select()::columns(["DayID", "DayOfWeek"])::table("day")::execute();
            $days = crud::fetch("all");
            if ($days) {
              foreach ($days as $day) { ?>
                <option value="<?php echo $day["DayID"] ?>"><?php echo $day["DayOfWeek"] ?></option>
            <?php }
            } ?>
          </select>
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="pre">Period</label>
          <select class="custom-select shadow-none font-12" id="pre" name="pre" required>
            <option value="">Select</option>
            <?php
            $periods = crud::select()::columns(["PeriodID", "Start_Time", "End_Time"])::table("period");
            $periods = crud::execute();
            $periods = crud::fetch("all");
            if ($periods) {
              foreach ($periods as $period) { ?>
                <option value="<?php echo $period["PeriodID"] ?>"><?php echo $period["Start_Time"] . " " . $period["End_Time"]; ?></option>
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
  $time = crud::select()::columns(["TimeSlotID", "DayID", "PeriodID"])::table("timeslot");
  $time = crud::where(["TimeSlotID" => $id])::execute();
  $time = crud::fetch("one");
  if ($time) { ?>
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
            <input class="form-control font-12" type="text" value="<?php echo $time['TimeSlotID'] ?>" disabled />
            <input name="id" type="hidden" value="<?php echo $time['TimeSlotID'] ?>" />
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="day">Day</label>
            <select class="custom-select shadow-none font-12" id="day" name="day" required>
              <option value="">Select</option>
              <?php
              $days = crud::select()::columns(["DayID", "DayOfWeek"])::table("day")::execute();
              $days = crud::fetch("all");
              if ($days) {
                foreach ($days as $day) { ?>
                  <option <?php echo ($day["DayID"] == $time["DayID"]) ? "selected" : ""; ?> value="<?php echo $day["DayID"] ?>"><?php echo $day["DayOfWeek"] ?></option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="pre">Period</label>
            <select class="custom-select shadow-none font-12" id="pre" name="pre" required>
              <option value="">Select</option>
              <?php
              $periods = crud::select()::columns(["PeriodID", "Start_Time", "End_Time"])::table("period");
              $periods = crud::execute();
              $periods = crud::fetch("all");
              if ($periods) {
                foreach ($periods as $period) { ?>
                  <option <?php echo ($period["PeriodID"] == $time["PeriodID"]) ? "selected" : ""; ?> value="<?php echo $period["PeriodID"] ?>"><?php echo $period["Start_Time"] . " " . $period["End_Time"]; ?></option>
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