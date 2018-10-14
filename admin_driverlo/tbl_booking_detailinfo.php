<?php

// Global variable for table object
$tbl_booking_detail = NULL;

//
// Table class for tbl_booking_detail
//
class ctbl_booking_detail extends cTable {
	var $fld_booking_ai_id;
	var $fld_customer_token;
	var $fld_pickup_point;
	var $fld_customer_name;
	var $fld_mobile_no;
	var $fld_booking_datetime;
	var $fld_coupon_code;
	var $fld_driver_rating;
	var $fld_customer_feedback;
	var $fld_is_cancelled;
	var $fld_total_fare;
	var $fld_booked_driver_id;
	var $fld_is_approved;
	var $fld_is_completed;
	var $fld_is_active;
	var $fld_created_on;
	var $fld_dropoff_point;
	var $fld_estimated_time;
	var $fld_estimated_fare;
	var $fld_brn_no;
	var $fld_journey_type;
	var $fld_vehicle_type;
	var $fld_vehicle_mode;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbl_booking_detail';
		$this->TableName = 'tbl_booking_detail';
		$this->TableType = 'TABLE';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// fld_booking_ai_id
		$this->fld_booking_ai_id = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_booking_ai_id', 'fld_booking_ai_id', '`fld_booking_ai_id`', '`fld_booking_ai_id`', 19, -1, FALSE, '`fld_booking_ai_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_booking_ai_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fld_booking_ai_id'] = &$this->fld_booking_ai_id;

		// fld_customer_token
		$this->fld_customer_token = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_customer_token', 'fld_customer_token', '`fld_customer_token`', '`fld_customer_token`', 200, -1, FALSE, '`fld_customer_token`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fld_customer_token'] = &$this->fld_customer_token;

		// fld_pickup_point
		$this->fld_pickup_point = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_pickup_point', 'fld_pickup_point', '`fld_pickup_point`', '`fld_pickup_point`', 200, -1, FALSE, '`fld_pickup_point`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fld_pickup_point'] = &$this->fld_pickup_point;

		// fld_customer_name
		$this->fld_customer_name = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_customer_name', 'fld_customer_name', '`fld_customer_name`', '`fld_customer_name`', 200, -1, FALSE, '`fld_customer_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fld_customer_name'] = &$this->fld_customer_name;

		// fld_mobile_no
		$this->fld_mobile_no = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_mobile_no', 'fld_mobile_no', '`fld_mobile_no`', '`fld_mobile_no`', 21, -1, FALSE, '`fld_mobile_no`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_mobile_no->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fld_mobile_no'] = &$this->fld_mobile_no;

		// fld_booking_datetime
		$this->fld_booking_datetime = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_booking_datetime', 'fld_booking_datetime', '`fld_booking_datetime`', 'DATE_FORMAT(`fld_booking_datetime`, \'%Y/%m/%d %H:%i:%s\')', 135, 9, FALSE, '`fld_booking_datetime`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_booking_datetime->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['fld_booking_datetime'] = &$this->fld_booking_datetime;

		// fld_coupon_code
		$this->fld_coupon_code = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_coupon_code', 'fld_coupon_code', '`fld_coupon_code`', '`fld_coupon_code`', 200, -1, FALSE, '`fld_coupon_code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fld_coupon_code'] = &$this->fld_coupon_code;

		// fld_driver_rating
		$this->fld_driver_rating = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_driver_rating', 'fld_driver_rating', '`fld_driver_rating`', '`fld_driver_rating`', 4, -1, FALSE, '`fld_driver_rating`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_driver_rating->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['fld_driver_rating'] = &$this->fld_driver_rating;

		// fld_customer_feedback
		$this->fld_customer_feedback = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_customer_feedback', 'fld_customer_feedback', '`fld_customer_feedback`', '`fld_customer_feedback`', 200, -1, FALSE, '`fld_customer_feedback`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fld_customer_feedback'] = &$this->fld_customer_feedback;

		// fld_is_cancelled
		$this->fld_is_cancelled = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_is_cancelled', 'fld_is_cancelled', '`fld_is_cancelled`', '`fld_is_cancelled`', 202, -1, FALSE, '`fld_is_cancelled`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_is_cancelled->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->fields['fld_is_cancelled'] = &$this->fld_is_cancelled;

		// fld_total_fare
		$this->fld_total_fare = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_total_fare', 'fld_total_fare', '`fld_total_fare`', '`fld_total_fare`', 4, -1, FALSE, '`fld_total_fare`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_total_fare->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['fld_total_fare'] = &$this->fld_total_fare;

		// fld_booked_driver_id
		$this->fld_booked_driver_id = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_booked_driver_id', 'fld_booked_driver_id', '`fld_booked_driver_id`', '`fld_booked_driver_id`', 3, -1, FALSE, '`fld_booked_driver_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_booked_driver_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fld_booked_driver_id'] = &$this->fld_booked_driver_id;

		// fld_is_approved
		$this->fld_is_approved = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_is_approved', 'fld_is_approved', '`fld_is_approved`', '`fld_is_approved`', 202, -1, FALSE, '`fld_is_approved`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_is_approved->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->fields['fld_is_approved'] = &$this->fld_is_approved;

		// fld_is_completed
		$this->fld_is_completed = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_is_completed', 'fld_is_completed', '`fld_is_completed`', '`fld_is_completed`', 202, -1, FALSE, '`fld_is_completed`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_is_completed->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->fields['fld_is_completed'] = &$this->fld_is_completed;

		// fld_is_active
		$this->fld_is_active = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_is_active', 'fld_is_active', '`fld_is_active`', '`fld_is_active`', 202, -1, FALSE, '`fld_is_active`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_is_active->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->fields['fld_is_active'] = &$this->fld_is_active;

		// fld_created_on
		$this->fld_created_on = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_created_on', 'fld_created_on', '`fld_created_on`', 'DATE_FORMAT(`fld_created_on`, \'%Y/%m/%d %H:%i:%s\')', 135, 9, FALSE, '`fld_created_on`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_created_on->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['fld_created_on'] = &$this->fld_created_on;

		// fld_dropoff_point
		$this->fld_dropoff_point = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_dropoff_point', 'fld_dropoff_point', '`fld_dropoff_point`', '`fld_dropoff_point`', 200, -1, FALSE, '`fld_dropoff_point`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fld_dropoff_point'] = &$this->fld_dropoff_point;

		// fld_estimated_time
		$this->fld_estimated_time = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_estimated_time', 'fld_estimated_time', '`fld_estimated_time`', '`fld_estimated_time`', 200, -1, FALSE, '`fld_estimated_time`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fld_estimated_time'] = &$this->fld_estimated_time;

		// fld_estimated_fare
		$this->fld_estimated_fare = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_estimated_fare', 'fld_estimated_fare', '`fld_estimated_fare`', '`fld_estimated_fare`', 3, -1, FALSE, '`fld_estimated_fare`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_estimated_fare->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fld_estimated_fare'] = &$this->fld_estimated_fare;

		// fld_brn_no
		$this->fld_brn_no = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_brn_no', 'fld_brn_no', '`fld_brn_no`', '`fld_brn_no`', 200, -1, FALSE, '`fld_brn_no`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fld_brn_no'] = &$this->fld_brn_no;

		// fld_journey_type
		$this->fld_journey_type = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_journey_type', 'fld_journey_type', '`fld_journey_type`', '`fld_journey_type`', 202, -1, FALSE, '`fld_journey_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fld_journey_type'] = &$this->fld_journey_type;

		// fld_vehicle_type
		$this->fld_vehicle_type = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_vehicle_type', 'fld_vehicle_type', '`fld_vehicle_type`', '`fld_vehicle_type`', 202, -1, FALSE, '`fld_vehicle_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fld_vehicle_type'] = &$this->fld_vehicle_type;

		// fld_vehicle_mode
		$this->fld_vehicle_mode = new cField('tbl_booking_detail', 'tbl_booking_detail', 'x_fld_vehicle_mode', 'fld_vehicle_mode', '`fld_vehicle_mode`', '`fld_vehicle_mode`', 202, -1, FALSE, '`fld_vehicle_mode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fld_vehicle_mode'] = &$this->fld_vehicle_mode;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`tbl_booking_detail`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "";
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
			$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->SqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . substr($sSql, 13);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$origFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Update Table
	var $UpdateTable = "`tbl_booking_detail`";

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		global $conn;
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "") {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL) {
		global $conn;
		return $conn->Execute($this->UpdateSQL($rs, $where));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "") {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if ($rs) {
			if (array_key_exists('fld_booking_ai_id', $rs))
				ew_AddFilter($where, ew_QuotedName('fld_booking_ai_id') . '=' . ew_QuotedValue($rs['fld_booking_ai_id'], $this->fld_booking_ai_id->FldDataType));
		}
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->DeleteSQL($rs, $where));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`fld_booking_ai_id` = @fld_booking_ai_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->fld_booking_ai_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@fld_booking_ai_id@", ew_AdjustSql($this->fld_booking_ai_id->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "tbl_booking_detaillist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbl_booking_detaillist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("tbl_booking_detailview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("tbl_booking_detailview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "tbl_booking_detailadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("tbl_booking_detailedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("tbl_booking_detailadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbl_booking_detaildelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->fld_booking_ai_id->CurrentValue)) {
			$sUrl .= "fld_booking_ai_id=" . urlencode($this->fld_booking_ai_id->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {
			$arKeys[] = @$_GET["fld_booking_ai_id"]; // fld_booking_ai_id

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->fld_booking_ai_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->fld_booking_ai_id->setDbValue($rs->fields('fld_booking_ai_id'));
		$this->fld_customer_token->setDbValue($rs->fields('fld_customer_token'));
		$this->fld_pickup_point->setDbValue($rs->fields('fld_pickup_point'));
		$this->fld_customer_name->setDbValue($rs->fields('fld_customer_name'));
		$this->fld_mobile_no->setDbValue($rs->fields('fld_mobile_no'));
		$this->fld_booking_datetime->setDbValue($rs->fields('fld_booking_datetime'));
		$this->fld_coupon_code->setDbValue($rs->fields('fld_coupon_code'));
		$this->fld_driver_rating->setDbValue($rs->fields('fld_driver_rating'));
		$this->fld_customer_feedback->setDbValue($rs->fields('fld_customer_feedback'));
		$this->fld_is_cancelled->setDbValue($rs->fields('fld_is_cancelled'));
		$this->fld_total_fare->setDbValue($rs->fields('fld_total_fare'));
		$this->fld_booked_driver_id->setDbValue($rs->fields('fld_booked_driver_id'));
		$this->fld_is_approved->setDbValue($rs->fields('fld_is_approved'));
		$this->fld_is_completed->setDbValue($rs->fields('fld_is_completed'));
		$this->fld_is_active->setDbValue($rs->fields('fld_is_active'));
		$this->fld_created_on->setDbValue($rs->fields('fld_created_on'));
		$this->fld_dropoff_point->setDbValue($rs->fields('fld_dropoff_point'));
		$this->fld_estimated_time->setDbValue($rs->fields('fld_estimated_time'));
		$this->fld_estimated_fare->setDbValue($rs->fields('fld_estimated_fare'));
		$this->fld_brn_no->setDbValue($rs->fields('fld_brn_no'));
		$this->fld_journey_type->setDbValue($rs->fields('fld_journey_type'));
		$this->fld_vehicle_type->setDbValue($rs->fields('fld_vehicle_type'));
		$this->fld_vehicle_mode->setDbValue($rs->fields('fld_vehicle_mode'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// fld_booking_ai_id
		// fld_customer_token

		$this->fld_customer_token->CellCssStyle = "white-space: nowrap;";

		// fld_pickup_point
		// fld_customer_name
		// fld_mobile_no
		// fld_booking_datetime
		// fld_coupon_code
		// fld_driver_rating
		// fld_customer_feedback
		// fld_is_cancelled
		// fld_total_fare
		// fld_booked_driver_id
		// fld_is_approved
		// fld_is_completed
		// fld_is_active
		// fld_created_on
		// fld_dropoff_point
		// fld_estimated_time
		// fld_estimated_fare
		// fld_brn_no
		// fld_journey_type
		// fld_vehicle_type
		// fld_vehicle_mode
		// fld_booking_ai_id

		$this->fld_booking_ai_id->ViewValue = $this->fld_booking_ai_id->CurrentValue;
		$this->fld_booking_ai_id->ViewCustomAttributes = "";

		// fld_customer_token
		$this->fld_customer_token->ViewValue = $this->fld_customer_token->CurrentValue;
		$this->fld_customer_token->ViewCustomAttributes = "";

		// fld_pickup_point
		$this->fld_pickup_point->ViewValue = $this->fld_pickup_point->CurrentValue;
		$this->fld_pickup_point->ViewCustomAttributes = "";

		// fld_customer_name
		$this->fld_customer_name->ViewValue = $this->fld_customer_name->CurrentValue;
		$this->fld_customer_name->ViewCustomAttributes = "";

		// fld_mobile_no
		$this->fld_mobile_no->ViewValue = $this->fld_mobile_no->CurrentValue;
		$this->fld_mobile_no->ViewCustomAttributes = "";

		// fld_booking_datetime
		$this->fld_booking_datetime->ViewValue = $this->fld_booking_datetime->CurrentValue;
		$this->fld_booking_datetime->ViewValue = ew_FormatDateTime($this->fld_booking_datetime->ViewValue, 9);
		$this->fld_booking_datetime->ViewCustomAttributes = "";

		// fld_coupon_code
		$this->fld_coupon_code->ViewValue = $this->fld_coupon_code->CurrentValue;
		$this->fld_coupon_code->ViewCustomAttributes = "";

		// fld_driver_rating
		$this->fld_driver_rating->ViewValue = $this->fld_driver_rating->CurrentValue;
		$this->fld_driver_rating->ViewCustomAttributes = "";

		// fld_customer_feedback
		$this->fld_customer_feedback->ViewValue = $this->fld_customer_feedback->CurrentValue;
		$this->fld_customer_feedback->ViewCustomAttributes = "";

		// fld_is_cancelled
		if (ew_ConvertToBool($this->fld_is_cancelled->CurrentValue)) {
			$this->fld_is_cancelled->ViewValue = $this->fld_is_cancelled->FldTagCaption(1) <> "" ? $this->fld_is_cancelled->FldTagCaption(1) : "1";
		} else {
			$this->fld_is_cancelled->ViewValue = $this->fld_is_cancelled->FldTagCaption(2) <> "" ? $this->fld_is_cancelled->FldTagCaption(2) : "0";
		}
		$this->fld_is_cancelled->ViewCustomAttributes = "";

		// fld_total_fare
		$this->fld_total_fare->ViewValue = $this->fld_total_fare->CurrentValue;
		$this->fld_total_fare->ViewCustomAttributes = "";

		// fld_booked_driver_id
		if (strval($this->fld_booked_driver_id->CurrentValue) <> "") {
			$sFilterWrk = "`fld_driver_ai_id`" . ew_SearchString("=", $this->fld_booked_driver_id->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `fld_driver_ai_id`, `fld_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_driver_info`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->fld_booked_driver_id, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->fld_booked_driver_id->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->fld_booked_driver_id->ViewValue = $this->fld_booked_driver_id->CurrentValue;
			}
		} else {
			$this->fld_booked_driver_id->ViewValue = NULL;
		}
		$this->fld_booked_driver_id->ViewCustomAttributes = "";

		// fld_is_approved
		if (ew_ConvertToBool($this->fld_is_approved->CurrentValue)) {
			$this->fld_is_approved->ViewValue = $this->fld_is_approved->FldTagCaption(1) <> "" ? $this->fld_is_approved->FldTagCaption(1) : "1";
		} else {
			$this->fld_is_approved->ViewValue = $this->fld_is_approved->FldTagCaption(2) <> "" ? $this->fld_is_approved->FldTagCaption(2) : "0";
		}
		$this->fld_is_approved->ViewCustomAttributes = "";

		// fld_is_completed
		if (ew_ConvertToBool($this->fld_is_completed->CurrentValue)) {
			$this->fld_is_completed->ViewValue = $this->fld_is_completed->FldTagCaption(1) <> "" ? $this->fld_is_completed->FldTagCaption(1) : "1";
		} else {
			$this->fld_is_completed->ViewValue = $this->fld_is_completed->FldTagCaption(2) <> "" ? $this->fld_is_completed->FldTagCaption(2) : "0";
		}
		$this->fld_is_completed->ViewCustomAttributes = "";

		// fld_is_active
		if (ew_ConvertToBool($this->fld_is_active->CurrentValue)) {
			$this->fld_is_active->ViewValue = $this->fld_is_active->FldTagCaption(1) <> "" ? $this->fld_is_active->FldTagCaption(1) : "1";
		} else {
			$this->fld_is_active->ViewValue = $this->fld_is_active->FldTagCaption(2) <> "" ? $this->fld_is_active->FldTagCaption(2) : "0";
		}
		$this->fld_is_active->ViewCustomAttributes = "";

		// fld_created_on
		$this->fld_created_on->ViewValue = $this->fld_created_on->CurrentValue;
		$this->fld_created_on->ViewValue = ew_FormatDateTime($this->fld_created_on->ViewValue, 9);
		$this->fld_created_on->ViewCustomAttributes = "";

		// fld_dropoff_point
		$this->fld_dropoff_point->ViewValue = $this->fld_dropoff_point->CurrentValue;
		$this->fld_dropoff_point->ViewCustomAttributes = "";

		// fld_estimated_time
		$this->fld_estimated_time->ViewValue = $this->fld_estimated_time->CurrentValue;
		$this->fld_estimated_time->ViewCustomAttributes = "";

		// fld_estimated_fare
		$this->fld_estimated_fare->ViewValue = $this->fld_estimated_fare->CurrentValue;
		$this->fld_estimated_fare->ViewCustomAttributes = "";

		// fld_brn_no
		$this->fld_brn_no->ViewValue = $this->fld_brn_no->CurrentValue;
		$this->fld_brn_no->ViewCustomAttributes = "";

		// fld_journey_type
		if (strval($this->fld_journey_type->CurrentValue) <> "") {
			switch ($this->fld_journey_type->CurrentValue) {
				case $this->fld_journey_type->FldTagValue(1):
					$this->fld_journey_type->ViewValue = $this->fld_journey_type->FldTagCaption(1) <> "" ? $this->fld_journey_type->FldTagCaption(1) : $this->fld_journey_type->CurrentValue;
					break;
				case $this->fld_journey_type->FldTagValue(2):
					$this->fld_journey_type->ViewValue = $this->fld_journey_type->FldTagCaption(2) <> "" ? $this->fld_journey_type->FldTagCaption(2) : $this->fld_journey_type->CurrentValue;
					break;
				case $this->fld_journey_type->FldTagValue(3):
					$this->fld_journey_type->ViewValue = $this->fld_journey_type->FldTagCaption(3) <> "" ? $this->fld_journey_type->FldTagCaption(3) : $this->fld_journey_type->CurrentValue;
					break;
				default:
					$this->fld_journey_type->ViewValue = $this->fld_journey_type->CurrentValue;
			}
		} else {
			$this->fld_journey_type->ViewValue = NULL;
		}
		$this->fld_journey_type->ViewCustomAttributes = "";

		// fld_vehicle_type
		if (strval($this->fld_vehicle_type->CurrentValue) <> "") {
			switch ($this->fld_vehicle_type->CurrentValue) {
				case $this->fld_vehicle_type->FldTagValue(1):
					$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->FldTagCaption(1) <> "" ? $this->fld_vehicle_type->FldTagCaption(1) : $this->fld_vehicle_type->CurrentValue;
					break;
				case $this->fld_vehicle_type->FldTagValue(2):
					$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->FldTagCaption(2) <> "" ? $this->fld_vehicle_type->FldTagCaption(2) : $this->fld_vehicle_type->CurrentValue;
					break;
				case $this->fld_vehicle_type->FldTagValue(3):
					$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->FldTagCaption(3) <> "" ? $this->fld_vehicle_type->FldTagCaption(3) : $this->fld_vehicle_type->CurrentValue;
					break;
				case $this->fld_vehicle_type->FldTagValue(4):
					$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->FldTagCaption(4) <> "" ? $this->fld_vehicle_type->FldTagCaption(4) : $this->fld_vehicle_type->CurrentValue;
					break;
				default:
					$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->CurrentValue;
			}
		} else {
			$this->fld_vehicle_type->ViewValue = NULL;
		}
		$this->fld_vehicle_type->ViewCustomAttributes = "";

		// fld_vehicle_mode
		if (strval($this->fld_vehicle_mode->CurrentValue) <> "") {
			switch ($this->fld_vehicle_mode->CurrentValue) {
				case $this->fld_vehicle_mode->FldTagValue(1):
					$this->fld_vehicle_mode->ViewValue = $this->fld_vehicle_mode->FldTagCaption(1) <> "" ? $this->fld_vehicle_mode->FldTagCaption(1) : $this->fld_vehicle_mode->CurrentValue;
					break;
				case $this->fld_vehicle_mode->FldTagValue(2):
					$this->fld_vehicle_mode->ViewValue = $this->fld_vehicle_mode->FldTagCaption(2) <> "" ? $this->fld_vehicle_mode->FldTagCaption(2) : $this->fld_vehicle_mode->CurrentValue;
					break;
				default:
					$this->fld_vehicle_mode->ViewValue = $this->fld_vehicle_mode->CurrentValue;
			}
		} else {
			$this->fld_vehicle_mode->ViewValue = NULL;
		}
		$this->fld_vehicle_mode->ViewCustomAttributes = "";

		// fld_booking_ai_id
		$this->fld_booking_ai_id->LinkCustomAttributes = "";
		$this->fld_booking_ai_id->HrefValue = "";
		$this->fld_booking_ai_id->TooltipValue = "";

		// fld_customer_token
		$this->fld_customer_token->LinkCustomAttributes = "";
		$this->fld_customer_token->HrefValue = "";
		$this->fld_customer_token->TooltipValue = "";

		// fld_pickup_point
		$this->fld_pickup_point->LinkCustomAttributes = "";
		$this->fld_pickup_point->HrefValue = "";
		$this->fld_pickup_point->TooltipValue = "";

		// fld_customer_name
		$this->fld_customer_name->LinkCustomAttributes = "";
		$this->fld_customer_name->HrefValue = "";
		$this->fld_customer_name->TooltipValue = "";

		// fld_mobile_no
		$this->fld_mobile_no->LinkCustomAttributes = "";
		$this->fld_mobile_no->HrefValue = "";
		$this->fld_mobile_no->TooltipValue = "";

		// fld_booking_datetime
		$this->fld_booking_datetime->LinkCustomAttributes = "";
		$this->fld_booking_datetime->HrefValue = "";
		$this->fld_booking_datetime->TooltipValue = "";

		// fld_coupon_code
		$this->fld_coupon_code->LinkCustomAttributes = "";
		$this->fld_coupon_code->HrefValue = "";
		$this->fld_coupon_code->TooltipValue = "";

		// fld_driver_rating
		$this->fld_driver_rating->LinkCustomAttributes = "";
		$this->fld_driver_rating->HrefValue = "";
		$this->fld_driver_rating->TooltipValue = "";

		// fld_customer_feedback
		$this->fld_customer_feedback->LinkCustomAttributes = "";
		$this->fld_customer_feedback->HrefValue = "";
		$this->fld_customer_feedback->TooltipValue = "";

		// fld_is_cancelled
		$this->fld_is_cancelled->LinkCustomAttributes = "";
		$this->fld_is_cancelled->HrefValue = "";
		$this->fld_is_cancelled->TooltipValue = "";

		// fld_total_fare
		$this->fld_total_fare->LinkCustomAttributes = "";
		$this->fld_total_fare->HrefValue = "";
		$this->fld_total_fare->TooltipValue = "";

		// fld_booked_driver_id
		$this->fld_booked_driver_id->LinkCustomAttributes = "";
		$this->fld_booked_driver_id->HrefValue = "";
		$this->fld_booked_driver_id->TooltipValue = "";

		// fld_is_approved
		$this->fld_is_approved->LinkCustomAttributes = "";
		$this->fld_is_approved->HrefValue = "";
		$this->fld_is_approved->TooltipValue = "";

		// fld_is_completed
		$this->fld_is_completed->LinkCustomAttributes = "";
		$this->fld_is_completed->HrefValue = "";
		$this->fld_is_completed->TooltipValue = "";

		// fld_is_active
		$this->fld_is_active->LinkCustomAttributes = "";
		$this->fld_is_active->HrefValue = "";
		$this->fld_is_active->TooltipValue = "";

		// fld_created_on
		$this->fld_created_on->LinkCustomAttributes = "";
		$this->fld_created_on->HrefValue = "";
		$this->fld_created_on->TooltipValue = "";

		// fld_dropoff_point
		$this->fld_dropoff_point->LinkCustomAttributes = "";
		$this->fld_dropoff_point->HrefValue = "";
		$this->fld_dropoff_point->TooltipValue = "";

		// fld_estimated_time
		$this->fld_estimated_time->LinkCustomAttributes = "";
		$this->fld_estimated_time->HrefValue = "";
		$this->fld_estimated_time->TooltipValue = "";

		// fld_estimated_fare
		$this->fld_estimated_fare->LinkCustomAttributes = "";
		$this->fld_estimated_fare->HrefValue = "";
		$this->fld_estimated_fare->TooltipValue = "";

		// fld_brn_no
		$this->fld_brn_no->LinkCustomAttributes = "";
		$this->fld_brn_no->HrefValue = "";
		$this->fld_brn_no->TooltipValue = "";

		// fld_journey_type
		$this->fld_journey_type->LinkCustomAttributes = "";
		$this->fld_journey_type->HrefValue = "";
		$this->fld_journey_type->TooltipValue = "";

		// fld_vehicle_type
		$this->fld_vehicle_type->LinkCustomAttributes = "";
		$this->fld_vehicle_type->HrefValue = "";
		$this->fld_vehicle_type->TooltipValue = "";

		// fld_vehicle_mode
		$this->fld_vehicle_mode->LinkCustomAttributes = "";
		$this->fld_vehicle_mode->HrefValue = "";
		$this->fld_vehicle_mode->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;

		// Write header
		$Doc->ExportTableHeader();
		if ($Doc->Horizontal) { // Horizontal format, write header
			$Doc->BeginExportRow();
			if ($ExportPageType == "view") {
				if ($this->fld_booking_ai_id->Exportable) $Doc->ExportCaption($this->fld_booking_ai_id);
				if ($this->fld_pickup_point->Exportable) $Doc->ExportCaption($this->fld_pickup_point);
				if ($this->fld_customer_name->Exportable) $Doc->ExportCaption($this->fld_customer_name);
				if ($this->fld_mobile_no->Exportable) $Doc->ExportCaption($this->fld_mobile_no);
				if ($this->fld_booking_datetime->Exportable) $Doc->ExportCaption($this->fld_booking_datetime);
				if ($this->fld_coupon_code->Exportable) $Doc->ExportCaption($this->fld_coupon_code);
				if ($this->fld_driver_rating->Exportable) $Doc->ExportCaption($this->fld_driver_rating);
				if ($this->fld_customer_feedback->Exportable) $Doc->ExportCaption($this->fld_customer_feedback);
				if ($this->fld_is_cancelled->Exportable) $Doc->ExportCaption($this->fld_is_cancelled);
				if ($this->fld_total_fare->Exportable) $Doc->ExportCaption($this->fld_total_fare);
				if ($this->fld_booked_driver_id->Exportable) $Doc->ExportCaption($this->fld_booked_driver_id);
				if ($this->fld_is_approved->Exportable) $Doc->ExportCaption($this->fld_is_approved);
				if ($this->fld_is_completed->Exportable) $Doc->ExportCaption($this->fld_is_completed);
				if ($this->fld_is_active->Exportable) $Doc->ExportCaption($this->fld_is_active);
				if ($this->fld_created_on->Exportable) $Doc->ExportCaption($this->fld_created_on);
				if ($this->fld_dropoff_point->Exportable) $Doc->ExportCaption($this->fld_dropoff_point);
				if ($this->fld_estimated_time->Exportable) $Doc->ExportCaption($this->fld_estimated_time);
				if ($this->fld_estimated_fare->Exportable) $Doc->ExportCaption($this->fld_estimated_fare);
				if ($this->fld_brn_no->Exportable) $Doc->ExportCaption($this->fld_brn_no);
				if ($this->fld_journey_type->Exportable) $Doc->ExportCaption($this->fld_journey_type);
				if ($this->fld_vehicle_type->Exportable) $Doc->ExportCaption($this->fld_vehicle_type);
				if ($this->fld_vehicle_mode->Exportable) $Doc->ExportCaption($this->fld_vehicle_mode);
			} else {
				if ($this->fld_booking_ai_id->Exportable) $Doc->ExportCaption($this->fld_booking_ai_id);
				if ($this->fld_pickup_point->Exportable) $Doc->ExportCaption($this->fld_pickup_point);
				if ($this->fld_customer_name->Exportable) $Doc->ExportCaption($this->fld_customer_name);
				if ($this->fld_mobile_no->Exportable) $Doc->ExportCaption($this->fld_mobile_no);
				if ($this->fld_booking_datetime->Exportable) $Doc->ExportCaption($this->fld_booking_datetime);
				if ($this->fld_coupon_code->Exportable) $Doc->ExportCaption($this->fld_coupon_code);
				if ($this->fld_driver_rating->Exportable) $Doc->ExportCaption($this->fld_driver_rating);
				if ($this->fld_customer_feedback->Exportable) $Doc->ExportCaption($this->fld_customer_feedback);
				if ($this->fld_is_cancelled->Exportable) $Doc->ExportCaption($this->fld_is_cancelled);
				if ($this->fld_total_fare->Exportable) $Doc->ExportCaption($this->fld_total_fare);
				if ($this->fld_booked_driver_id->Exportable) $Doc->ExportCaption($this->fld_booked_driver_id);
				if ($this->fld_is_approved->Exportable) $Doc->ExportCaption($this->fld_is_approved);
				if ($this->fld_is_completed->Exportable) $Doc->ExportCaption($this->fld_is_completed);
				if ($this->fld_is_active->Exportable) $Doc->ExportCaption($this->fld_is_active);
				if ($this->fld_created_on->Exportable) $Doc->ExportCaption($this->fld_created_on);
				if ($this->fld_dropoff_point->Exportable) $Doc->ExportCaption($this->fld_dropoff_point);
				if ($this->fld_estimated_time->Exportable) $Doc->ExportCaption($this->fld_estimated_time);
				if ($this->fld_estimated_fare->Exportable) $Doc->ExportCaption($this->fld_estimated_fare);
				if ($this->fld_brn_no->Exportable) $Doc->ExportCaption($this->fld_brn_no);
				if ($this->fld_journey_type->Exportable) $Doc->ExportCaption($this->fld_journey_type);
				if ($this->fld_vehicle_type->Exportable) $Doc->ExportCaption($this->fld_vehicle_type);
				if ($this->fld_vehicle_mode->Exportable) $Doc->ExportCaption($this->fld_vehicle_mode);
			}
			$Doc->EndExportRow();
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
				if ($ExportPageType == "view") {
					if ($this->fld_booking_ai_id->Exportable) $Doc->ExportField($this->fld_booking_ai_id);
					if ($this->fld_pickup_point->Exportable) $Doc->ExportField($this->fld_pickup_point);
					if ($this->fld_customer_name->Exportable) $Doc->ExportField($this->fld_customer_name);
					if ($this->fld_mobile_no->Exportable) $Doc->ExportField($this->fld_mobile_no);
					if ($this->fld_booking_datetime->Exportable) $Doc->ExportField($this->fld_booking_datetime);
					if ($this->fld_coupon_code->Exportable) $Doc->ExportField($this->fld_coupon_code);
					if ($this->fld_driver_rating->Exportable) $Doc->ExportField($this->fld_driver_rating);
					if ($this->fld_customer_feedback->Exportable) $Doc->ExportField($this->fld_customer_feedback);
					if ($this->fld_is_cancelled->Exportable) $Doc->ExportField($this->fld_is_cancelled);
					if ($this->fld_total_fare->Exportable) $Doc->ExportField($this->fld_total_fare);
					if ($this->fld_booked_driver_id->Exportable) $Doc->ExportField($this->fld_booked_driver_id);
					if ($this->fld_is_approved->Exportable) $Doc->ExportField($this->fld_is_approved);
					if ($this->fld_is_completed->Exportable) $Doc->ExportField($this->fld_is_completed);
					if ($this->fld_is_active->Exportable) $Doc->ExportField($this->fld_is_active);
					if ($this->fld_created_on->Exportable) $Doc->ExportField($this->fld_created_on);
					if ($this->fld_dropoff_point->Exportable) $Doc->ExportField($this->fld_dropoff_point);
					if ($this->fld_estimated_time->Exportable) $Doc->ExportField($this->fld_estimated_time);
					if ($this->fld_estimated_fare->Exportable) $Doc->ExportField($this->fld_estimated_fare);
					if ($this->fld_brn_no->Exportable) $Doc->ExportField($this->fld_brn_no);
					if ($this->fld_journey_type->Exportable) $Doc->ExportField($this->fld_journey_type);
					if ($this->fld_vehicle_type->Exportable) $Doc->ExportField($this->fld_vehicle_type);
					if ($this->fld_vehicle_mode->Exportable) $Doc->ExportField($this->fld_vehicle_mode);
				} else {
					if ($this->fld_booking_ai_id->Exportable) $Doc->ExportField($this->fld_booking_ai_id);
					if ($this->fld_pickup_point->Exportable) $Doc->ExportField($this->fld_pickup_point);
					if ($this->fld_customer_name->Exportable) $Doc->ExportField($this->fld_customer_name);
					if ($this->fld_mobile_no->Exportable) $Doc->ExportField($this->fld_mobile_no);
					if ($this->fld_booking_datetime->Exportable) $Doc->ExportField($this->fld_booking_datetime);
					if ($this->fld_coupon_code->Exportable) $Doc->ExportField($this->fld_coupon_code);
					if ($this->fld_driver_rating->Exportable) $Doc->ExportField($this->fld_driver_rating);
					if ($this->fld_customer_feedback->Exportable) $Doc->ExportField($this->fld_customer_feedback);
					if ($this->fld_is_cancelled->Exportable) $Doc->ExportField($this->fld_is_cancelled);
					if ($this->fld_total_fare->Exportable) $Doc->ExportField($this->fld_total_fare);
					if ($this->fld_booked_driver_id->Exportable) $Doc->ExportField($this->fld_booked_driver_id);
					if ($this->fld_is_approved->Exportable) $Doc->ExportField($this->fld_is_approved);
					if ($this->fld_is_completed->Exportable) $Doc->ExportField($this->fld_is_completed);
					if ($this->fld_is_active->Exportable) $Doc->ExportField($this->fld_is_active);
					if ($this->fld_created_on->Exportable) $Doc->ExportField($this->fld_created_on);
					if ($this->fld_dropoff_point->Exportable) $Doc->ExportField($this->fld_dropoff_point);
					if ($this->fld_estimated_time->Exportable) $Doc->ExportField($this->fld_estimated_time);
					if ($this->fld_estimated_fare->Exportable) $Doc->ExportField($this->fld_estimated_fare);
					if ($this->fld_brn_no->Exportable) $Doc->ExportField($this->fld_brn_no);
					if ($this->fld_journey_type->Exportable) $Doc->ExportField($this->fld_journey_type);
					if ($this->fld_vehicle_type->Exportable) $Doc->ExportField($this->fld_vehicle_type);
					if ($this->fld_vehicle_mode->Exportable) $Doc->ExportField($this->fld_vehicle_mode);
				}
				$Doc->EndExportRow();
			}
			$Recordset->MoveNext();
		}
		$Doc->ExportTableFooter();
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
