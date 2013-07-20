<?php
class ErrorType {

	// Login errors
	const LENGTH_BETWEEN = 1;
	const NO_SPACES = 2;
	const CHAR_NOT_PRESENT= 3;
	const ILLEGAL_CHAR_PRESENT = 4;
	const USERNAME_CENSURED = 5;
	//const WRONG_USERNAME = 6;
	const WRONG_PASSWORD = 7;
	const USER_NOT_APPROVED = 8;
	const USER_DISABLED = 9;

	// ObjManager errors
	const OBJ_NOT_CREATED = 20;
	const OBJ_NOT_LOADED = 21;
	const OBJ_NOT_INSERTED = 22;
	const OBJ_NOT_UPDATED = 23;
	const OBJ_NOT_DELETED = 24;
	const OBJ_NOT_LISTED = 25;
	const OBJ_NOT_RETRIEVED = 26;

	// SimpleEnquirer errors
	const OBJ_NOT_FOUND = 30;
	const LIST_NOT_FOUND = 31;

	// Session errors
	const SESSION_NOT_DESTROYED = 40;

	// Page errors
	const PAGE_DENIED = 50;
	const PAGE_NOT_FOUND = 51;

	// Registration errors
	const FORM_NOT_FILLED = 60;
	const WRONG_NAME = 61;
	const WRONG_SURNAME = 62;
	const WRONG_EMAIL = 63;
	const WRONG_USERSTRING = 64;
	const PW1_NOT_EQUALS_PW2 = 65;
	const USERNAME_NOT_AVAILABLE = 66;
	const WRONG_CAPTCHA_CODE = 67;
	const EMAIL_USED_YET = 68;
	const WRONG_PW_STRING = 69;
	const WRONG_ADMIN_PW_STRING = 70;

	// Change password errors
	const CHPW_FORM_NOT_FILLED = 71;
	const CHPW_PW1_NOT_EQUALS_PW2 = 72;
	const CHPW_WRONG_PW_STRING = 73;
	const CHPW_WRONG_ADMIN_PW_STRING = 74;
	const CHPW_WRONG_PASSWORD = 75;

	// Email confirmation errors
	const REG_HACK_ATTEMPT = 80;
}

?>