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
          <input class="form-control font-12" id="id" name="id" type="text" required />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="name">Name</label>
          <input class="form-control font-12" id="name" name="name" type="text" required />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="contact">Contact</label>
          <input class="form-control font-12" id="contact" name="contact" type="text" required />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="chairman">Chairman</label>
          <input class="form-control font-12" id="chairman" name="chairman" type="text" required />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="manager">Manager</label>
          <input class="form-control font-12" id="manager" name="manager" type="text" required />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="room">Room</label>
          <select class="custom-select font-12" id="room" name="room" required>
            <option value="">Select</option>
            <?php
            $rooms = crud::select()::columns(["r.RoomNumber", "b.Name", "r.RoomID", "r.RoomType"]);
            $rooms = crud::table("room as r");
            $rooms = crud::join(["building AS b" => ["b.BuildingID" => "r.BuildingID"]], "LEFT")::execute();
            $rooms = crud::fetch("all");
            if ($rooms) {
              foreach ($rooms as $room) { ?>
                <option value="<?php echo $room["RoomID"] ?>">
                  <?php echo "Room (" . $room["RoomNumber"] . ") - (" . $room["RoomType"] . ") - " . $room["Name"] ?>
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
  $department = crud::select();
  $department = crud::columns(["DeptID", "Name", "Contact", "Chairman", "Manager", "RoomID"]);
  $department = crud::table("department");
  $department = crud::where(["DeptID" => $id]);
  $department = crud::execute();
  $department = crud::fetch("one");

  if ($department) { ?>
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
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="id">ID</label>
            <input class="form-control font-12" id="id" name="id" type="text" value="<?php echo $department['DeptID'] ?>" disabled />
            <input name="id" type="hidden" value="<?php echo $department['DeptID'] ?>" required />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="name">Name</label>
            <input class="form-control font-12" id="name" name="name" type="text" value="<?php echo $department['Name'] ?>" required />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="contact">Contact</label>
            <input class="form-control font-12" id="contact" name="contact" value="<?php echo $department['Contact'] ?>" type="text" required />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="chairman">Chairman</label>
            <input class="form-control font-12" id="chairman" name="chairman" value="<?php echo $department['Chairman'] ?>" type="text" required />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="manager">Manager</label>
            <input class="form-control font-12" id="manager" name="manager" value="<?php echo $department['Manager'] ?>" type="text" required />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="room">Room</label>
            <select class="custom-select font-12" id="room" name="room" required>
              <option value="">Select</option>
              <?php
              $rooms = crud::select();
              $rooms = crud::columns(["r.RoomNumber", "b.Name", "r.RoomID", "r.RoomType"]);
              $rooms = crud::table("room as r");
              $rooms = crud::join(["building AS b" => ["b.BuildingID" => "r.BuildingID"]], "LEFT");
              $rooms = crud::execute();
              $rooms = crud::fetch("all");
              if ($rooms) {
                foreach ($rooms as $room) { ?>
                  <option <?php echo ($department["RoomID"] == $room["RoomID"]) ? "selected" : ""; ?> value="<?php echo $room["RoomID"] ?>">
                    <?php echo "Room (" . $room["RoomNumber"] . ") - (" . $room["RoomType"] . ") - " . $room["Name"] ?>
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