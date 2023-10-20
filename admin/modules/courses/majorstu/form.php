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
          <label class="font-weight-bolder mb-0" for="major">Major</label>
          <select class="custom-select font-12" id="major" name="major" required>
            <option value="">Select</option>
            <?php
            $majors = crud::select()::columns(["MajorID", "Name"])::table("major")::execute();
            $majors = crud::fetch("all");
            if ($majors) {
              foreach ($majors as $major) { ?>
                <option value="<?php echo $major["MajorID"] ?>"><?php echo $major["Name"]; ?></option>
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
  $major = crud::select()::columns(["id", "MajorID"])::table("studentmajor")::where(["id" => $id])::execute();
  $major = crud::fetch("one");

  if ($major) { ?>
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
          <input name="id" type="hidden" value="<?php echo $major['id']; ?>" />
          <div class="form-group col-sm-12 mb-2">
            <label class="font-weight-bolder mb-0" for="major">Major</label>
            <select class="custom-select font-12" id="major" name="major" required>
              <option value="">Select</option>
              <?php
              $majors = crud::select()::columns(["MajorID", "Name"])::table("major")::execute();
              $majors = crud::fetch("all");
              if ($majors) {
                foreach ($majors as $majorr) { ?>
                  <option <?php echo ($majorr["MajorID"] == $major["MajorID"]) ? "selected" : ""; ?> value="<?php echo $majorr["MajorID"] ?>"><?php echo $majorr["Name"]; ?></option>
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