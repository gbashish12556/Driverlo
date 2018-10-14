<?php

// Global variable for table object
$tbl_coupon_discount = NULL;

//
// Table class for tbl_coupon_discount
//
class ctbl_coupon_discount extends cTable {
	var $fld_coupon_id;
	var $fld_coupon_code;
	var $fld_coupon_discount;
	var $fld_is_validated;
	var $fld_is_active;
	var $fld_created_on;
	var $fld_is_referal;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbl_coupon_discount';
		$this->TableName = 'tbl_coupon_discount';
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

		// fld_coupon_id
		$this->fld_coupon_id = new cField('tbl_coupon_discount', 'tbl_coupon_discount', 'x_fld_coupon_id', 'fld_coupon_id', '`fld_coupon_id`', '`fld_coupon_id`', 19, -1, FALSE, '`fld_coupon_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_coupon_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fld_coupon_id'] = &$this->fld_coupon_id;

		// fld_coupon_code
		$this->fld_coupon_code = new cField('tbl_coupon_discount', 'tbl_coupon_discount', 'x_fld_coupon_code', 'fld_coupon_code', '`fld_coupon_code`', '`fld_coupon_code`', 200, -1, FALSE, '`fld_coupon_code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fld_coupon_code'] = &$this->fld_coupon_code;

		// fld_coupon_discount
		$this->fld_coupon_discount = new cField('tbl_coupon_discount', 'tbl_coupon_discount', 'x_fld_coupon_discount', 'fld_coupon_discount', '`fld_coupon_discount`', '`fld_coupon_discount`', 3, -1, FALSE, '`fld_coupon_discount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_coupon_discount->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fld_coupon_discount'] = &$this->fld_coupon_discount;

		// fld_is_validated
		$this->fld_is_validated = new cField('tbl_coupon_discount', 'tbl_coupon_discount', 'x_fld_is_validated', 'fld_is_validated', '`fld_is_validated`', '`fld_is_validated`', 202, -1, FALSE, '`fld_is_validated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_is_validated->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->fields['fld_is_validated'] = &$this->fld_is_validated;

		// fld_is_active
		$this->fld_is_active = new cField('tbl_coupon_discount', 'tbl_coupon_discount', 'x_fld_is_active', 'fld_is_active', '`fld_is_active`', '`fld_is_active`', 202, -1, FALSE, '`fld_is_active`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_is_active->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->fields['fld_is_active'] = &$this->fld_is_active;

		// fld_created_on
		$this->fld_created_on = new cField('tbl_coupon_discount', 'tbl_coupon_discount', 'x_fld_created_on', 'fld_created_on', '`fld_created_on`', 'DATE_FORMAT(`fld_created_on`, \'%Y/%m/%d %H:%i:%s\')', 135, 9, FALSE, '`fld_created_on`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_created_on->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['fld_created_on'] = &$this->fld_created_on;

		// fld_is_referal
		$this->fld_is_referal = new cField('tbl_coupon_discount', 'tbl_coupon_discount', 'x_fld_is_referal', 'fld_is_referal', '`fld_is_referal`', '`fld_is_referal`', 202, -1, FALSE, '`fld_is_referal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fld_is_referal->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->fields['fld_is_referal'] = &$this->fld_is_referal;
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
		return "`tbl_coupon_discount`";
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
	var $UpdateTable = "`tbl_coupon_discount`";

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
			if (array_key_exists('fld_coupon_id', $rs))
				ew_AddFilter($where, ew_QuotedName('fld_coupon_id') . '=' . ew_QuotedValue($rs['fld_coupon_id'], $this->fld_coupon_id->FldDataType));
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
		return "`fld_coupon_id` = @fld_coupon_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->fld_coupon_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@fld_coupon_id@", ew_AdjustSql($this->fld_coupon_id->CurrentValue), $sKeyFilter); // Replace key value
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
			return "tbl_coupon_discountlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbl_coupon_discountlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("tbl_coupon_discountview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("tbl_coupon_discountview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "tbl_coupon_discountadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("tbl_coupon_discountedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("tbl_coupon_discountadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbl_coupon_discountdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->fld_coupon_id->CurrentValue)) {
			$sUrl .= "fld_coupon_id=" . urlencode($this->fld_coupon_id->CurrentValue);
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
			$arKeys[] = @$_GET["fld_coupon_id"]; // fld_coupon_id

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
			$this->fld_coupon_id->CurrentValue = $key;
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
		$this->fld_coupon_id->setDbValue($rs->fields('fld_coupon_id'));
		$this->fld_coupon_code->setDbValue($rs->fields('fld_coupon_code'));
		$this->fld_coupon_discount->setDbValue($rs->fields('fld_coupon_discount'));
		$this->fld_is_validated->setDbValue($rs->fields('fld_is_validated'));
		$this->fld_is_active->setDbValue($rs->fields('fld_is_active'));
		$this->fld_created_on->setDbValue($rs->fields('fld_created_on'));
		$this->fld_is_referal->setDbValue($rs->fields('fld_is_referal'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// fld_coupon_id
		// fld_coupon_code
		// fld_coupon_discount
		// fld_is_validated
		// fld_is_active
		// fld_created_on
		// fld_is_referal
		// fld_coupon_id

		$this->fld_coupon_id->ViewValue = $this->fld_coupon_id->CurrentValue;
		$this->fld_coupon_id->ViewCustomAttributes = "";

		// fld_coupon_code
		$this->fld_coupon_code->ViewValue = $this->fld_coupon_code->CurrentValue;
		$this->fld_coupon_code->ViewCustomAttributes = "";

		// fld_coupon_discount
		$this->fld_coupon_discount->ViewValue = $this->fld_coupon_discount->CurrentValue;
		$this->fld_coupon_discount->ViewCustomAttributes = "";

		// fld_is_validated
		if (ew_ConvertToBool($this->fld_is_validated->CurrentValue)) {
			$this->fld_is_validated->ViewValue = $this->fld_is_validated->FldTagCaption(1) <> "" ? $this->fld_is_validated->FldTagCaption(1) : "1";
		} else {
			$this->fld_is_validated->ViewValue = $this->fld_is_validated->FldTagCaption(2) <> "" ? $this->fld_is_validated->FldTagCaption(2) : "0";
		}
		$this->fld_is_validated->ViewCustomAttributes = "";

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

		// fld_is_referal
		if (ew_ConvertToBool($this->fld_is_referal->CurrentValue)) {
			$this->fld_is_referal->ViewValue = $this->fld_is_referal->FldTagCaption(1) <> "" ? $this->fld_is_referal->FldTagCaption(1) : "1";
		} else {
			$this->fld_is_referal->ViewValue = $this->fld_is_referal->FldTagCaption(2) <> "" ? $this->fld_is_referal->FldTagCaption(2) : "0";
		}
		$this->fld_is_referal->ViewCustomAttributes = "";

		// fld_coupon_id
		$this->fld_coupon_id->LinkCustomAttributes = "";
		$this->fld_coupon_id->HrefValue = "";
		$this->fld_coupon_id->TooltipValue = "";

		// fld_coupon_code
		$this->fld_coupon_code->LinkCustomAttributes = "";
		$this->fld_coupon_code->HrefValue = "";
		$this->fld_coupon_code->TooltipValue = "";

		// fld_coupon_discount
		$this->fld_coupon_discount->LinkCustomAttributes = "";
		$this->fld_coupon_discount->HrefValue = "";
		$this->fld_coupon_discount->TooltipValue = "";

		// fld_is_validated
		$this->fld_is_validated->LinkCustomAttributes = "";
		$this->fld_is_validated->HrefValue = "";
		$this->fld_is_validated->TooltipValue = "";

		// fld_is_active
		$this->fld_is_active->LinkCustomAttributes = "";
		$this->fld_is_active->HrefValue = "";
		$this->fld_is_active->TooltipValue = "";

		// fld_created_on
		$this->fld_created_on->LinkCustomAttributes = "";
		$this->fld_created_on->HrefValue = "";
		$this->fld_created_on->TooltipValue = "";

		// fld_is_referal
		$this->fld_is_referal->LinkCustomAttributes = "";
		$this->fld_is_referal->HrefValue = "";
		$this->fld_is_referal->TooltipValue = "";

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
				if ($this->fld_coupon_id->Exportable) $Doc->ExportCaption($this->fld_coupon_id);
				if ($this->fld_coupon_code->Exportable) $Doc->ExportCaption($this->fld_coupon_code);
				if ($this->fld_coupon_discount->Exportable) $Doc->ExportCaption($this->fld_coupon_discount);
				if ($this->fld_is_validated->Exportable) $Doc->ExportCaption($this->fld_is_validated);
				if ($this->fld_is_active->Exportable) $Doc->ExportCaption($this->fld_is_active);
				if ($this->fld_created_on->Exportable) $Doc->ExportCaption($this->fld_created_on);
				if ($this->fld_is_referal->Exportable) $Doc->ExportCaption($this->fld_is_referal);
			} else {
				if ($this->fld_coupon_id->Exportable) $Doc->ExportCaption($this->fld_coupon_id);
				if ($this->fld_coupon_code->Exportable) $Doc->ExportCaption($this->fld_coupon_code);
				if ($this->fld_coupon_discount->Exportable) $Doc->ExportCaption($this->fld_coupon_discount);
				if ($this->fld_is_validated->Exportable) $Doc->ExportCaption($this->fld_is_validated);
				if ($this->fld_is_active->Exportable) $Doc->ExportCaption($this->fld_is_active);
				if ($this->fld_created_on->Exportable) $Doc->ExportCaption($this->fld_created_on);
				if ($this->fld_is_referal->Exportable) $Doc->ExportCaption($this->fld_is_referal);
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
					if ($this->fld_coupon_id->Exportable) $Doc->ExportField($this->fld_coupon_id);
					if ($this->fld_coupon_code->Exportable) $Doc->ExportField($this->fld_coupon_code);
					if ($this->fld_coupon_discount->Exportable) $Doc->ExportField($this->fld_coupon_discount);
					if ($this->fld_is_validated->Exportable) $Doc->ExportField($this->fld_is_validated);
					if ($this->fld_is_active->Exportable) $Doc->ExportField($this->fld_is_active);
					if ($this->fld_created_on->Exportable) $Doc->ExportField($this->fld_created_on);
					if ($this->fld_is_referal->Exportable) $Doc->ExportField($this->fld_is_referal);
				} else {
					if ($this->fld_coupon_id->Exportable) $Doc->ExportField($this->fld_coupon_id);
					if ($this->fld_coupon_code->Exportable) $Doc->ExportField($this->fld_coupon_code);
					if ($this->fld_coupon_discount->Exportable) $Doc->ExportField($this->fld_coupon_discount);
					if ($this->fld_is_validated->Exportable) $Doc->ExportField($this->fld_is_validated);
					if ($this->fld_is_active->Exportable) $Doc->ExportField($this->fld_is_active);
					if ($this->fld_created_on->Exportable) $Doc->ExportField($this->fld_created_on);
					if ($this->fld_is_referal->Exportable) $Doc->ExportField($this->fld_is_referal);
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
