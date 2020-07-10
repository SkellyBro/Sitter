//This function handles the validation for the login form
function loginVal(login){
	var errorCount=0;
	
	//email validation
	if(login.uName.value == "" || login.uName.value == null){
		document.getElementById("email_err").style.color = "#FF0000";
		document.getElementById("email_err").innerHTML="You must enter an email!";
		errorCount++;
	}
	
	if((login.uName.value).length<5 || (login.uName.value).length>25){
		document.getElementById("email_err").style.color="#FF0000";
		document.getElementById("email_err").innerHTML="Your username must be between 5-25 characters!";
		errorCount++;
	}
	
	//password validation
	if(login.password.value == "" || login.password.value== null){
		document.getElementById("password_err").style.color = "#FF0000";
		document.getElementById("password_err").innerHTML="You must enter your password!";
		errorCount++;
	}
	
	//password validation
	if(login.password.value == "" || login.password.value== null){
		document.getElementById("password_err").style.color = "#FF0000";
		document.getElementById("password_err").innerHTML="You must enter your password!";
		errorCount++;
	}
	
	if((login.password.value).length< 8){
		document.getElementById("password_err").style.color = "#FF0000";
		document.getElementById("password_err").innerHTML="Your password must be more than 8 characters!";
		errorCount++;
	}
	
	//errorCheck
	if(errorCount>0){
		return false;
	}else{
		return true;
	}
}//end of loginVal

//This function handles the validation for the registration form
function registrationVal(reg){
	
	var errorCount=0;
	
	//username validation
	if(reg.uName.value=="" || reg.uName.value== null){
		document.getElementById("user_err").style.color="#FF0000";
		document.getElementById("user_err").innerHTML="You must enter a username!";
		errorCount++;
	}
	
	if((reg.uName.value).length<5 || (reg.uName.value).length>25){
		document.getElementById("user_err").style.color="#FF0000";
		document.getElementById("user_err").innerHTML="Your username must be between 5-25 characters!";
		errorCount++;
	}
	/*
	Code adapted from: https://stackoverflow.com/questions/388996/regex-for-javascript-to-allow-only-alphanumeric
	Code Author: Chase Seibert, starscream_disco_party
	Accessed on: 28 Feb 2019. 
	*/
	
	if(!/^\w+$/.test(reg.uName.value)){
		document.getElementById("user_err").style.color = "#FF0000";
		document.getElementById("user_err").innerHTML="Special characters are not allowed!";
		errorCount++;
	}//end of username validation
	
	//firstname validation
	if(reg.fName.value=="" || reg.fName.value== null){
		document.getElementById("fname_err").style.color="#FF0000";
		document.getElementById("fname_err").innerHTML="You must enter your first name!";
		errorCount++;
	}

	if((reg.fName.value).length<3 || (reg.fName.value).length>25){
		document.getElementById("fname_err").style.color="#FF0000";
		document.getElementById("fname_err").innerHTML="Your first name must be between 3-25 characters!";
		errorCount++;
	}
	
	if(!/^\w+$/.test(reg.fName.value)){
		document.getElementById("fname_err").style.color = "#FF0000";
		document.getElementById("fname_err").innerHTML="Spaces and special characters are not allowed!";
		errorCount++;
	}
	
	if(!/^[a-zA-Z]+$/.test(reg.fName.value)){
		document.getElementById("fname_err").style.color = "#FF0000";
		document.getElementById("fname_err").innerHTML="Only letters are allowed!";
		errorCount++;
	}//end of firstname validation
		
	
	//lastname validation
	if(reg.lName.value=="" || reg.lName.value== null){
		document.getElementById("lname_err").style.color="#FF0000";
		document.getElementById("lname_err").innerHTML="You must enter a last name!";
		errorCount++;
	}
	
	if((reg.lName.value).length<3 || (reg.lName.value).length>25){
		document.getElementById("lname_err").style.color="#FF0000";
		document.getElementById("lname_err").innerHTML="Your lastname must be between 3-25 characters!";
		errorCount++;
	}
	
	if(!/^\w+$/.test(reg.lName.value)){
		document.getElementById("lname_err").style.color = "#FF0000";
		document.getElementById("lname_err").innerHTML="Spaces and special characters are not allowed!";
		errorCount++;
	}
	
	if(!/^[a-zA-Z]+$/.test(reg.lName.value)){
		document.getElementById("lname_err").style.color = "#FF0000";
		document.getElementById("lname_err").innerHTML="Only letters are allowed!";
		errorCount++;
	}//end of username validation
	
	//email validation
	if(reg.email.value=="" || reg.email.value==null){
		document.getElementById("email_err").style.color="#FF0000";
		document.getElementById("email_err").innerHTML="You must enter your email address";
		errorCount++;
	}
	
	/*
	Code adapted from: https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
	Code Author: rnevius
	Accessed on: 28 Feb 2019. 
	*/
	
	if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(reg.email.value)){
		document.getElementById("email_err").style.color = "#FF0000";
		document.getElementById("email_err").innerHTML="Email is not in format xyz@xyz.com!";
		errorCount++;
	}//end of email validation
	
	//password validation
	if(reg.password.value == "" || reg.password.value== null){
		document.getElementById("password_err").style.color = "#FF0000";
		document.getElementById("password_err").innerHTML="You must enter your password!";
		errorCount++;
	}
	
	if((reg.password.value).length<8){
		document.getElementById("password_err").style.color = "#FF0000";
		document.getElementById("password_err").innerHTML="Your password must contain 8 characters!";
		errorCount++;
	}
	
	//confirm password validation
	//password validation
	if(reg.cpassword.value == "" || reg.cpassword.value== null){
		document.getElementById("cpass_err").style.color = "#FF0000";
		document.getElementById("cpass_err").innerHTML="You must confirm your password!";
		errorCount++;
	}
	
	if(reg.cpassword.value != reg.password.value){
		document.getElementById("cpass_err").style.color = "#FF0000";
		document.getElementById("cpass_err").innerHTML="Passwords do not match!";
		errorCount++;
	}
	
	//Captcha validation
	if(reg.captcha_code.value=="" || reg.captcha_code.value==null){
		document.getElementById("captcha_err").style.color = "#FF0000";
		document.getElementById("captcha_err").innerHTML="You must enter the captcha!";
		errorCount++;
	}
	
	//errorCheck
	if(errorCount>0){
		return false;
	}else{
		return true;
	}
}//end of registrationVal

//this is responsible for validating the verification page
function verify(vForm){
	var errorCount=0;
	
	if((vForm.vCode.value).length<5){
		document.getElementById("code_err").style.color = "#FF0000";
		document.getElementById("code_err").innerHTML="Verification code must be exactly 5 characters!";
		errorCount++;
	}
	
	if(vForm.vCode.value=="" || vForm.vCode.value==null){
		document.getElementById("code_err").style.color = "#FF0000";
		document.getElementById("code_err").innerHTML="You must enter a verification code!";
		errorCount++;
	}//end of verify
	
	/*
	Code adapted from: https://stackoverflow.com/questions/9011524/regex-to-check-whether-a-string-contains-only-numbers
	Code accessed on: 7/04/2019
	Code Author: Mike Samuel
	
	*/
	
	if(!/^\d+$/.test(vForm.vCode.value)){
		document.getElementById("code_err").style.color = "#FF0000";
		document.getElementById("code_err").innerHTML="Your verification code can only contain numbers!";
		errorCount++;
	}//end of verify
	
	if(errorCount>0){
		return false;
	}else{
		return true;
	}
}//end of verify

//this is responsible for validating the new post data
function postVal(pCreate){
	var errorCount=0;
	
	//postal code validation
	if(pCreate.pCode.value==""|| pCreate.pCode.value==null){
		document.getElementById("pcode_err").style.color = "#FF0000";
		document.getElementById("pcode_err").innerHTML="You must enter a post code!";
		errorCount++;
	}
	
	if((pCreate.pCode.value).length>4){
		document.getElementById("pcode_err").style.color = "#FF0000";
		document.getElementById("pcode_err").innerHTML="Postal codes cannot be more than 4 characters!";
		errorCount++;
	}
	
	if(!/^[a-zA-Z]+$/.test(pCreate.pCode.value)){
		document.getElementById("pcode_err").style.color = "#FF0000";
		document.getElementById("pcode_err").innerHTML="Postal code cannot contain spaces, numbers or special characters!";
		errorCount++;
	}
	
	//sitter type validation
	if(pCreate.sitterType.value=="" || pCreate.sitterType.value==null){
		document.getElementById("sitter_err").style.color = "#FF0000";
		document.getElementById("sitter_err").innerHTML="You must choose a sitter type!";
		errorCount++;
	}
	
	//function to check the days sitters would be available
	checkAvail(pCreate, errorCount);
	
	//price validation
	if(pCreate.price.value=="" || pCreate.price.value==null){
		document.getElementById("price_err").style.color = "#FF0000";
		document.getElementById("price_err").innerHTML="You must enter a price for your services!";
		errorCount++;
	}
	
	if(pCreate.price.value<10 || pCreate.price.value>1000){
		document.getElementById("price_err").style.color = "#FF0000";
		document.getElementById("price_err").innerHTML="Your price cannot be lower than $10.00 or higher than $1000.00!";
		errorCount++;
	}
	
	if(!/^\d+$/.test(pCreate.price.value)){
		document.getElementById("price_err").style.color = "#FF0000";
		document.getElementById("price_err").innerHTML="Price must be numeric!";
		errorCount++;
	}
	
	//extra details validation
	if(pCreate.eDesc.value=="" || pCreate.eDesc.value==null){
		document.getElementById("desc_err").style.color = "#FF0000";
		document.getElementById("desc_err").innerHTML="You must enter some details about yourself!";
		errorCount++;
	}
	
	if((pCreate.eDesc.value).length==0){
		document.getElementById("desc_err").style.color = "#FF0000";
		document.getElementById("desc_err").innerHTML="You must enter some details about yourself!";
		errorCount++;
	}
	
	if((pCreate.eDesc.value).length>1000){
		document.getElementById("desc_err").style.color = "#FF0000";
		document.getElementById("desc_err").innerHTML="You cannot enter more than 1000 characters!!";
		errorCount++;
	}
	
	
	if(errorCount>0){
		return false;
	}else{
		return true;
	}
}//end of postVal

/*

Code accessed on: 26 Mar 2019
Code adapted from: https://www.sitepoint.com/community/t/checking-if-at-east-1-checkbox-is-selected-in-an-array-of-checkboxes/2719/3
Code Author: LuckyB

*/
function checkAvail(pCreate, errorCount){
	var checked=false;
	var checkbox = document.getElementsByName("dAvail[]");
	for(var i=0; i < checkbox.length; i++){
		if(checkbox[i].checked) {
			checked = true;
		}
	}
	if (!checked) {
		document.getElementById("avail_err").style.color = "#FF0000";
		document.getElementById("avail_err").innerHTML="You must choose a day for availability!";
		errorCount++;
	}
	return errorCount;
	return checked;
}//end of checkAvail

//function that asks a user to confirm if they want to delete their post or not
function confirmation(){
	var x = confirm("Are you sure you want to delete this post?");
	if (x){
      return true;
	}else{
	  return false;
	}
}
//function to validate data seom the sitter registration form
function sitterRegVal(sReg){
	var errorCount=0; 
	
	if(sReg.pNum.value=="" || sReg.pNum.value==null){
		document.getElementById("pNum_err").style.color = "#FF0000";
		document.getElementById("pNum_err").innerHTML="You must enter a phone number!";
		errorCount++;
	}
	
	if(!/^\d+$/.test(sReg.pNum.value)){
		document.getElementById("pNum_err").style.color = "#FF0000";
		document.getElementById("pNum_err").innerHTML="Phone number can only contain numbers!";
		errorCount++;
	}
	
	if((sReg.pNum.value).length<7){
		document.getElementById("pNum_err").style.color = "#FF0000";
		document.getElementById("pNum_err").innerHTML="Phone number must be atleast 7 characters!";
		errorCount++;
	}
	
	if((sReg.pNum.value).length>15){
		document.getElementById("pNum_err").style.color = "#FF0000";
		document.getElementById("pNum_err").innerHTML="Phone number cannot be more than 15 characters!";
		errorCount++;
	}
	
	if(sReg.exp.value=="" || sReg.exp.value==null){
		document.getElementById("exp_err").style.color = "#FF0000";
		document.getElementById("exp_err").innerHTML="You must enter some of your experience!";
		errorCount++;
	}
	
	if((sReg.exp.value).length>500){
		document.getElementById("exp_err").style.color = "#FF0000";
		document.getElementById("exp_err").innerHTML="Your experience cannot be more than 500 characters!";
		errorCount++;
	}
	
	if(!sReg.agree.checked){
		document.getElementById("agree_err").style.color = "#FF0000";
		document.getElementById("agree_err").innerHTML="You must agree to the terms of service!";
		errorCount++;
	}
	
	if(errorCount>0){
		return false;
	}else{
		return true;
	}
}//end of function sitterRegVal

function valSearch(sitSearch){
	var errorCount=0;

	//postal code validation
	if(sitSearch.sLoc.value==""|| sitSearch.sLoc.value==null){
		document.getElementById("pcode_err").style.color = "#FF0000";
		document.getElementById("pcode_err").innerHTML="You must enter a post code!";
		errorCount++;
	}

	if((sitSearch.sLoc.value).length>4){
		document.getElementById("pcode_err").style.color = "#FF0000";
		document.getElementById("pcode_err").innerHTML="Postal codes cannot be more than 4 characters!";
		errorCount++;
	}

	//sitter type validation
	if(sitSearch.sitterType.value=="" || sitSearch.sitterType.value==null){
		document.getElementById("sitter_err").style.color = "#FF0000";
		document.getElementById("sitter_err").innerHTML="You must choose a sitter type!";
		errorCount++;
	}

	if(errorCount>0){
		return false;
	}else{
		return true;
	}
}