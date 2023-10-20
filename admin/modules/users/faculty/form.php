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
        <div class="form-group col-sm-4 mb-0">
          <label class="font-weight-bolder mb-0" for="id">ID</label>
          <input class="form-control" type="text" id="id" name="id" required />
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="fname">Firstname</label>
          <input class="form-control" id="fname" name="fname" type="text" value="<?php echo $user['F_Name'] ?>" required />
        </div>
        <div class="form-group col-sm-4 mb-2">
          <label class="font-weight-bolder mb-0" for="lname">Lastname</label>
          <input class="form-control" id="lname" name="lname" type="text" value="<?php echo $user['L_Name'] ?>" required />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="email">Email</label>
          <input class="form-control font-12" id="email" name="email" type="email" required />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="phone">Phone</label>
          <input class="form-control font-12" id="phone" name="phone" type="text" />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="password">Password</label>
          <input class="form-control font-12" id="password" name="password" type="password" required />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="dob">Dob</label>
          <input class="form-control font-12" id="dob" name="dob" type="date" pattern="\d{2}-\d{2}-\d{4}" required />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="department">Department</label>
          <select class="custom-select font-12" id="department" name="department" required>
            <option value="">Select</option>
            <?php
            $departments = crud::select()::columns(["DeptID", "Name"])::table("department");
            $departments = crud::execute();
            $departments = crud::fetch("all");
            if ($departments) {
              foreach ($departments as $department) { ?>
                <option <?php echo ($department["DeptID"] == $major["DeptID"]) ? "selected" : ""; ?> value="<?php echo $department["DeptID"] ?>"><?php echo $department["Name"]; ?></option>
            <?php }
            } ?>
          </select>
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="type">Type</label>
          <select class="custom-select font-12" id="type" name="type" required>
            <option value="">Select</option>
            <option value="Part Time">Part time</option>
            <option value="Full Time">Full time</option>
          </select>
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="min">Min courses</label>
          <input class="form-control font-12" id="min" name="min" type="text" />
        </div>
        <div class="form-group col-sm-6 mb-2">
          <label class="font-weight-bolder mb-0" for="max">Max courses</label>
          <input class="form-control font-12" id="max" name="max" type="text" />
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
  $user = crud::select();
  $user = crud::columns(["u.UserID", "u.F_Name", "u.L_Name", "u.DOB", "u.Phone"]);
  $user = crud::columnsmore(["u.Email", "u.Password", "f.FacultyType", "u.DateCreated", "d.DeptID"]);
  $user = crud::columnsmore(["f.MinCourse", "f.MaxCourse"]);
  $user = crud::table("users as u");
  $user = crud::join(["faculty AS f" => ["f.FacultyID" => "u.UserID"]], "LEFT");
  $user = crud::join(["department AS d" => ["d.DeptID" => "f.DeptID"]], "LEFT");
  $user = crud::where(["u.UserID" => $id]);
  $user = crud::execute();
  $user = crud::fetch("one");

  if ($user) { ?>
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
          <div class="form-group col-sm-4 mb-0">
            <label class="font-weight-bolder mb-0" for="id">ID</label>
            <input class="form-control" type="text" value="<?php echo $user['UserID']; ?>" disabled />
            <input name="id" type="hidden" value="<?php echo $user['UserID']; ?>" />
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="fname">Firstname</label>
            <input class="form-control" id="fname" name="fname" type="text" value="<?php echo $user['F_Name'] ?>" required />
          </div>
          <div class="form-group col-sm-4 mb-2">
            <label class="font-weight-bolder mb-0" for="lname">Lastname</label>
            <input class="form-control" id="lname" name="lname" type="text" value="<?php echo $user['L_Name'] ?>" required />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="email">Email</label>
            <input class="form-control" id="email" name="email" type="email" value="<?php echo $user['Email'] ?>" required />
            <input name="oemail" type="hidden" value="<?php echo $user['Email'] ?>" />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="password">Password</label>
            <input class="form-control" id="password" name="password" type="password" />
            <input name="opassword" type="hidden" value="<?php echo $user['Password'] ?>" />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="phone">Phone</label>
            <input class="form-control font-12" id="phone" name="phone" value="<?php echo $user['Phone'] ?>" type="text" />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="dob">Dob</label>
            <input class="form-control font-12" id="dob" name="dob" type="date" value="<?php echo date('Y-m-d', strtotime($user['DOB'])) ?>" pattern="\d{2}-\d{2}-\d{4}" required />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="department">Department</label>
            <select class="custom-select font-12" id="department" name="department" required>
              <option value="">Select</option>
              <?php
              $departments = crud::select()::columns(["DeptID", "Name"])::table("department");
              $departments = crud::execute();
              $departments = crud::fetch("all");
              if ($departments) {
                foreach ($departments as $department) { ?>
                  <option <?php echo ($department["DeptID"] == $user["DeptID"]) ? "selected" : ""; ?> value="<?php echo $department["DeptID"] ?>"><?php echo $department["Name"]; ?></option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="type">Type</label>
            <select class="custom-select font-12" id="type" name="type" required>
              <optgroup label="Selected">
                <option value="<?php echo $user["FacultyType"]; ?>"><?php echo $user["FacultyType"]; ?></option>
              </optgroup>
              <option value="Part Time">Part time</option>
              <option value="Full Time">Full time</option>
            </select>
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="min">Min</label>
            <input class="form-control font-12" value=" <?php echo $user["MinCourse"]; ?>" id="min" name="min" type="text" />
          </div>
          <div class="form-group col-sm-6 mb-2">
            <label class="font-weight-bolder mb-0" for="max">Max</label>
            <input class="form-control font-12" value=" <?php echo $user["MaxCourse"]; ?>" id="max" name="max" type="text" />
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