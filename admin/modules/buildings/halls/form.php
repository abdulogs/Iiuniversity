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
        <div class="form-group col-sm-12 mb-2">
          <label class="font-weight-bolder mb-0" for="id">ID</label>
          <input class="form-control font-12" id="id" name="id" type="text" required />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="building">Building</label>
          <select class="custom-select font-12" id="building" name="building" required>
            <option value="">Select</option>
            <?php
            $buildings = crud::select()::columns(["BuildingID", "Name"])::table("building")::execute();
            $buildings = crud::fetch("all");
            if ($buildings) {
              foreach ($buildings as $building) { ?>
                <option value="<?php echo $building["BuildingID"] ?>"><?php echo $building["Name"] ?></option>
            <?php }
            } ?>
          </select>
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="number">Room Number</label>
          <input class="form-control font-12" id="number" name="number" type="text" required />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="capacity">Capacity</label>
          <input class="form-control font-12" id="capacity" name="capacity" type="text" required />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="seats">Seats</label>
          <input class="form-control font-12" id="seats" name="seats" type="text" required />
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
  $room = crud::select()::columns(["RoomID", "RoomNumber", "BuildingID", "Capacity", "Seats"]);
  $room = crud::table("room")::where(["RoomID" => $id])::execute();
  $room = crud::fetch("one");

  if ($room) { ?>
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
          <div class="form-group col-sm-12 mb-2">
            <label class="font-weight-bolder mb-0" for="id">ID</label>
            <input class="form-control font-12" type="text" value="<?php echo $room['RoomID'] ?>" disabled />
            <input id="id" name="id" type="hidden" value="<?php echo $room['RoomID'] ?>" />
          </div>

          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="building">Building</label>
            <select class="custom-select font-12" id="building" name="building" required>
              <option value="">Select</option>
              <?php
              $buildings = crud::select()::columns(["BuildingID", "Name"])::table("building")::execute();
              $buildings = crud::fetch("all");
              if ($buildings) {
                foreach ($buildings as $building) { ?>
                  <option <?php echo ($building["BuildingID"] == $room["BuildingID"]) ? "selected" : ""; ?> value="<?php echo $building["BuildingID"] ?>"><?php echo $building["Name"] ?></option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="number">Room Number</label>
            <input class="form-control font-12" id="number" name="number" type="text" value="<?php echo $room['RoomNumber'] ?>" required />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="capacity">Capacity</label>
            <input class="form-control font-12" id="capacity" name="capacity" type="text" value="<?php echo $room['Capacity'] ?>" required />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="seats">Seats</label>
            <input class="form-control font-12" id="seats" name="seats" type="text" value="<?php echo $room['Seats'] ?>" required />
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