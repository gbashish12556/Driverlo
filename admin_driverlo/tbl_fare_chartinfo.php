<?php

// Global variable for table object
$tbl_fare_chart = NULL;

//
// Table class for tbl_fare_chart
//
class ctbl_fare_chart extends cTable {
	var $fld_city_id;
	var $fld_city_name;
	var $fld_city_lat;
	var $fld_city_lng;
	var $fld_base_fare;
	var $fld_fare;
	var $fld_night_charge;
	var $fld_return_charge;
	var $fld_outstation_base_fare;
	var $fld_outstation_fare;
	var $fld_is_active;
	var $fld_created_on;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbl_fare_chart';
		$this->TableName = 'tbl_fare_chart';
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

		// fld_city_id
		$this->fld_city_id = new cField('tbl_fare_chart', 'tbl_fare_chart', 'x_fld_city_id', 'fld_city_id', '`fld_city_id`', '`fld_city_id`', 19, -1, FALSE, '`fld_city_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_city_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fld_city_id'] = &$this->fld_city_id;

		// fld_city_name
		$this->fld_city_name = new cField('tbl_fare_chart', 'tbl_fare_chart', 'x_fld_city_name', 'fld_city_name', '`fld_city_name`', '`fld_city_name`', 200, -1, FALSE, '`fld_city_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fld_city_name'] = &$this->fld_city_name;

		// fld_city_lat
		$this->fld_city_lat = new cField('tbl_fare_chart', 'tbl_fare_chart', 'x_fld_city_lat', 'fld_city_lat', '`fld_city_lat`', '`fld_city_lat`', 4, -1, FALSE, '`fld_city_lat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_city_lat->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['fld_city_lat'] = &$this->fld_city_lat;

		// fld_city_lng
		$this->fld_city_lng = new cField('tbl_fare_chart', 'tbl_fare_chart', 'x_fld_city_lng', 'fld_city_lng', '`fld_city_lng`', '`fld_city_lng`', 4, -1, FALSE, '`fld_city_lng`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_city_lng->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['fld_city_lng'] = &$this->fld_city_lng;

		// fld_base_fare
		$this->fld_base_fare = new cField('tbl_fare_chart', 'tbl_fare_chart', 'x_fld_base_fare', 'fld_base_fare', '`fld_base_fare`', '`fld_base_fare`', 3, -1, FALSE, '`fld_base_fare`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_base_fare->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fld_base_fare'] = &$this->fld_base_fare;

		// fld_fare
		$this->fld_fare = new cField('tbl_fare_chart', 'tbl_fare_chart', 'x_fld_fare', 'fld_fare', '`fld_fare`', '`fld_fare`', 3, -1, FALSE, '`fld_fare`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_fare->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fld_fare'] = &$this->fld_fare;

		// fld_night_charge
		$this->fld_night_charge = new cField('tbl_fare_chart', 'tbl_fare_chart', 'x_fld_night_charge', 'fld_night_charge', '`fld_night_charge`', '`fld_night_charge`', 3, -1, FALSE, '`fld_night_charge`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_night_charge->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fld_night_charge'] = &$this->fld_night_charge;

		// fld_return_charge
		$this->fld_return_charge = new cField('tbl_fare_chart', 'tbl_fare_chart', 'x_fld_return_charge', 'fld_return_charge', '`fld_return_charge`', '`fld_return_charge`', 3, -1, FALSE, '`fld_return_charge`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_return_charge->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fld_return_charge'] = &$this->fld_return_charge;

		// fld_outstation_base_fare
		$this->fld_outstation_base_fare = new cField('tbl_fare_chart', 'tbl_fare_chart', 'x_fld_outstation_base_fare', 'fld_outstation_base_fare', '`fld_outstation_base_fare`', '`fld_outstation_base_fare`', 3, -1, FALSE, '`fld_outstation_base_fare`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_outstation_base_fare->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fld_outstation_base_fare'] = &$this->fld_outstation_base_fare;

		// fld_outstation_fare
		$this->fld_outstation_fare = new cField('tbl_fare_chart', 'tbl_fare_chart', 'x_fld_outstation_fare', 'fld_outstation_fare', '`fld_outstation_fare`', '`fld_outstation_fare`', 3, -1, FALSE, '`fld_outstation_fare`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_outstation_fare->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fld_outstation_fare'] = &$this->fld_outstation_fare;

		// fld_is_active
		$this->fld_is_active = new cField('tbl_fare_chart', 'tbl_fare_chart', 'x_fld_is_active', 'fld_is_active', '`fld_is_active`', '`fld_is_active`', 202, -1, FALSE, '`fld_is_active`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_is_active->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->fields['fld_is_active'] = &$this->fld_is_active;

		// fld_created_on
		$this->fld_created_on = new cField('tbl_fare_chart', 'tbl_fare_chart', 'x_fld_created_on', 'fld_created_on', '`fld_created_on`', 'DATE_FORMAT(`fld_created_on`, \'%Y/%m/%d %H:%i:%s\')', 135, 9, FALSE, '`fld_created_on`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fld_created_on'] = &$this->fld_created_on;
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
		return "`tbl_fare_chart`";
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
	var $UpdateTable = "`tbl_fare_chart`";

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
			if (array_key_exists('fld_city_id', $rs))
				ew_AddFilter($where, ew_QuotedName('fld_city_id') . '=' . ew_QuotedValue($rs['fld_city_id'], $this->fld_city_id->FldDataType));
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
		return "`fld_city_id` = @fld_city_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->fld_city_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@fld_city_id@", ew_AdjustSql($this->fld_city_id->CurrentValue), $sKeyFilter); // Replace key value
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
			return "tbl_fare_chartlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbl_fare_chartlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("tbl_fare_chartview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("tbl_fare_chartview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "tbl_fare_chartadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("tbl_fare_chartedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("tbl_fare_chartadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbl_fare_chartdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->fld_city_id->CurrentValue)) {
			$sUrl .= "fld_city_id=" . urlencode($this->fld_city_id->CurrentValue);
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
			$arKeys[] = @$_GET["fld_city_id"]; // fld_city_id

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
			$this->fld_city_id->CurrentValue = $key;
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
		$this->fld_city_id->setDbValue($rs->fields('fld_city_id'));
		$this->fld_city_name->setDbValue($rs->fields('fld_city_name'));
		$this->fld_city_lat->setDbValue($rs->fields('fld_city_lat'));
		$this->fld_city_lng->setDbValue($rs->fields('fld_city_lng'));
		$this->fld_base_fare->setDbValue($rs->fields('fld_base_fare'));
		$this->fld_fare->setDbValue($rs->fields('fld_fare'));
		$this->fld_night_charge->setDbValue($rs->fields('fld_night_charge'));
		$this->fld_return_charge->setDbValue($rs->fields('fld_return_charge'));
		$this->fld_outstation_base_fare->setDbValue($rs->fields('fld_outstation_base_fare'));
		$this->fld_outstation_fare->setDbValue($rs->fields('fld_outstation_fare'));
		$this->fld_is_active->setDbValue($rs->fields('fld_is_active'));
		$this->fld_created_on->setDbValue($rs->fields('fld_created_on'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// fld_city_id
		// fld_city_name
		// fld_city_lat
		// fld_city_lng
		// fld_base_fare
		// fld_fare
		// fld_night_charge
		// fld_return_charge
		// fld_outstation_base_fare
		// fld_outstation_fare
		// fld_is_active
		// fld_created_on
		// fld_city_id

		$this->fld_city_id->ViewValue = $this->fld_city_id->CurrentValue;
		$this->fld_city_id->ViewCustomAttributes = "";

		// fld_city_name
		$this->fld_city_name->ViewValue = $this->fld_city_name->CurrentValue;
		$this->fld_city_name->ViewCustomAttributes = "";

		// fld_city_lat
		$this->fld_city_lat->ViewValue = $this->fld_city_lat->CurrentValue;
		$this->fld_city_lat->ViewCustomAttributes = "";

		// fld_city_lng
		$this->fld_city_lng->ViewValue = $this->fld_city_lng->CurrentValue;
		$this->fld_city_lng->ViewCustomAttributes = "";

		// fld_base_fare
		$this->fld_base_fare->ViewValue = $this->fld_base_fare->CurrentValue;
		$this->fld_base_fare->ViewCustomAttributes = "";

		// fld_fare
		$this->fld_fare->ViewValue = $this->fld_fare->CurrentValue;
		$this->fld_fare->ViewCustomAttributes = "";

		// fld_night_charge
		$this->fld_night_charge->ViewValue = $this->fld_night_charge->CurrentValue;
		$this->fld_night_charge->ViewCustomAttributes = "";

		// fld_return_charge
		$this->fld_return_charge->ViewValue = $this->fld_return_charge->CurrentValue;
		$this->fld_return_charge->ViewCustomAttributes = "";

		// fld_outstation_base_fare
		$this->fld_outstation_base_fare->ViewValue = $this->fld_outstation_base_fare->CurrentValue;
		$this->fld_outstation_base_fare->ViewCustomAttributes = "";

		// fld_outstation_fare
		$this->fld_outstation_fare->ViewValue = $this->fld_outstation_fare->CurrentValue;
		$this->fld_outstation_fare->ViewCustomAttributes = "";

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

		// fld_city_id
		$this->fld_city_id->LinkCustomAttributes = "";
		$this->fld_city_id->HrefValue = "";
		$this->fld_city_id->TooltipValue = "";

		// fld_city_name
		$this->fld_city_name->LinkCustomAttributes = "";
		$this->fld_city_name->HrefValue = "";
		$this->fld_city_name->TooltipValue = "";

		// fld_city_lat
		$this->fld_city_lat->LinkCustomAttributes = "";
		$this->fld_city_lat->HrefValue = "";
		$this->fld_city_lat->TooltipValue = "";

		// fld_city_lng
		$this->fld_city_lng->LinkCustomAttributes = "";
		$this->fld_city_lng->HrefValue = "";
		$this->fld_city_lng->TooltipValue = "";

		// fld_base_fare
		$this->fld_base_fare->LinkCustomAttributes = "";
		$this->fld_base_fare->HrefValue = "";
		$this->fld_base_fare->TooltipValue = "";

		// fld_fare
		$this->fld_fare->LinkCustomAttributes = "";
		$this->fld_fare->HrefValue = "";
		$this->fld_fare->TooltipValue = "";

		// fld_night_charge
		$this->fld_night_charge->LinkCustomAttributes = "";
		$this->fld_night_charge->HrefValue = "";
		$this->fld_night_charge->TooltipValue = "";

		// fld_return_charge
		$this->fld_return_charge->LinkCustomAttributes = "";
		$this->fld_return_charge->HrefValue = "";
		$this->fld_return_charge->TooltipValue = "";

		// fld_outstation_base_fare
		$this->fld_outstation_base_fare->LinkCustomAttributes = "";
		$this->fld_outstation_base_fare->HrefValue = "";
		$this->fld_outstation_base_fare->TooltipValue = "";

		// fld_outstation_fare
		$this->fld_outstation_fare->LinkCustomAttributes = "";
		$this->fld_outstation_fare->HrefValue = "";
		$this->fld_outstation_fare->TooltipValue = "";

		// fld_is_active
		$this->fld_is_active->LinkCustomAttributes = "";
		$this->fld_is_active->HrefValue = "";
		$this->fld_is_active->TooltipValue = "";

		// fld_created_on
		$this->fld_created_on->LinkCustomAttributes = "";
		$this->fld_created_on->HrefValue = "";
		$this->fld_created_on->TooltipValue = "";

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
				if ($this->fld_city_id->Exportable) $Doc->ExportCaption($this->fld_city_id);
				if ($this->fld_city_name->Exportable) $Doc->ExportCaption($this->fld_city_name);
				if ($this->fld_city_lat->Exportable) $Doc->ExportCaption($this->fld_city_lat);
				if ($this->fld_city_lng->Exportable) $Doc->ExportCaption($this->fld_city_lng);
				if ($this->fld_base_fare->Exportable) $Doc->ExportCaption($this->fld_base_fare);
				if ($this->fld_fare->Exportable) $Doc->ExportCaption($this->fld_fare);
				if ($this->fld_night_charge->Exportable) $Doc->ExportCaption($this->fld_night_charge);
				if ($this->fld_return_charge->Exportable) $Doc->ExportCaption($this->fld_return_charge);
				if ($this->fld_outstation_base_fare->Exportable) $Doc->ExportCaption($this->fld_outstation_base_fare);
				if ($this->fld_outstation_fare->Exportable) $Doc->ExportCaption($this->fld_outstation_fare);
				if ($this->fld_is_active->Exportable) $Doc->ExportCaption($this->fld_is_active);
				if ($this->fld_created_on->Exportable) $Doc->ExportCaption($this->fld_created_on);
			} else {
				if ($this->fld_city_id->Exportable) $Doc->ExportCaption($this->fld_city_id);
				if ($this->fld_city_name->Exportable) $Doc->ExportCaption($this->fld_city_name);
				if ($this->fld_city_lat->Exportable) $Doc->ExportCaption($this->fld_city_lat);
				if ($this->fld_city_lng->Exportable) $Doc->ExportCaption($this->fld_city_lng);
				if ($this->fld_base_fare->Exportable) $Doc->ExportCaption($this->fld_base_fare);
				if ($this->fld_fare->Exportable) $Doc->ExportCaption($this->fld_fare);
				if ($this->fld_night_charge->Exportable) $Doc->ExportCaption($this->fld_night_charge);
				if ($this->fld_return_charge->Exportable) $Doc->ExportCaption($this->fld_return_charge);
				if ($this->fld_outstation_base_fare->Exportable) $Doc->ExportCaption($this->fld_outstation_base_fare);
				if ($this->fld_outstation_fare->Exportable) $Doc->ExportCaption($this->fld_outstation_fare);
				if ($this->fld_is_active->Exportable) $Doc->ExportCaption($this->fld_is_active);
				if ($this->fld_created_on->Exportable) $Doc->ExportCaption($this->fld_created_on);
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
					if ($this->fld_city_id->Exportable) $Doc->ExportField($this->fld_city_id);
					if ($this->fld_city_name->Exportable) $Doc->ExportField($this->fld_city_name);
					if ($this->fld_city_lat->Exportable) $Doc->ExportField($this->fld_city_lat);
					if ($this->fld_city_lng->Exportable) $Doc->ExportField($this->fld_city_lng);
					if ($this->fld_base_fare->Exportable) $Doc->ExportField($this->fld_base_fare);
					if ($this->fld_fare->Exportable) $Doc->ExportField($this->fld_fare);
					if ($this->fld_night_charge->Exportable) $Doc->ExportField($this->fld_night_charge);
					if ($this->fld_return_charge->Exportable) $Doc->ExportField($this->fld_return_charge);
					if ($this->fld_outstation_base_fare->Exportable) $Doc->ExportField($this->fld_outstation_base_fare);
					if ($this->fld_outstation_fare->Exportable) $Doc->ExportField($this->fld_outstation_fare);
					if ($this->fld_is_active->Exportable) $Doc->ExportField($this->fld_is_active);
					if ($this->fld_created_on->Exportable) $Doc->ExportField($this->fld_created_on);
				} else {
					if ($this->fld_city_id->Exportable) $Doc->ExportField($this->fld_city_id);
					if ($this->fld_city_name->Exportable) $Doc->ExportField($this->fld_city_name);
					if ($this->fld_city_lat->Exportable) $Doc->ExportField($this->fld_city_lat);
					if ($this->fld_city_lng->Exportable) $Doc->ExportField($this->fld_city_lng);
					if ($this->fld_base_fare->Exportable) $Doc->ExportField($this->fld_base_fare);
					if ($this->fld_fare->Exportable) $Doc->ExportField($this->fld_fare);
					if ($this->fld_night_charge->Exportable) $Doc->ExportField($this->fld_night_charge);
					if ($this->fld_return_charge->Exportable) $Doc->ExportField($this->fld_return_charge);
					if ($this->fld_outstation_base_fare->Exportable) $Doc->ExportField($this->fld_outstation_base_fare);
					if ($this->fld_outstation_fare->Exportable) $Doc->ExportField($this->fld_outstation_fare);
					if ($this->fld_is_active->Exportable) $Doc->ExportField($this->fld_is_active);
					if ($this->fld_created_on->Exportable) $Doc->ExportField($this->fld_created_on);
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
