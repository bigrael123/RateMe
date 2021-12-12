<?php

//database auth data
$host="localhost";
$port=3306;
$socket="";
$user="id16395863_root";
$password="Shinikage-978";
$dbname="id16395863_accountdata";

//code vars
$jsondata = file_get_contents("php://input"); //data coming from app
$userdata = json_decode($jsondata); //decode json from app into an object
$conn = new mysqli($host, $user, $password, $dbname, $port, $socket) //connecting to server
	or die ('Could not connect to the database server' . mysqli_connect_error());
$sql = "SELECT AccountID, Email, Username, Password, First_Name, Last_Name, Account_Birth, Birthday, Zip_Code, City, State, Country, Ethnicity, Job, Sexuality, Gender, Phone FROM accountdata";  //information to be acquired from database
$result = $conn->query($sql); //Acquiring information into var
$currentaccount = $userdata;
//executing code
$wrongpass = false;
$Count = 0;
if ($result->num_rows > 0) {
  // output data of each row
  
  while($row = $result->fetch_assoc()) { //checks all entries in the database
		//login code
		$Count++;
      if($userdata->Logging && $wrongpass == false && $userdata->logged == false){ 
          if($row['Email'] == $userdata->Email || $row['Username'] == $userdata->Username){  
              if($row['Password'] == $userdata->Password){
                  //Login code goes here
				  $userdata->message = $userdata->message." Login Succesfull!";
				  $userdata->AccountID = $row['AccountID'];
				  $userdata->Email = $row['Email'];
				  $userdata->Username = $row['Username'];
				  $userdata->Password = $row['Password'];
				  $userdata->Name = $row['Name'];
				  $userdata->LName = $row['LName'];
				  $userdata->Account_Birth = $row['Account_Birth'];
				  $userdata->Birthday = $row['Birthday'];
				  $userdata->Zip_Code  = $row['Zip_Code'];
				  $userdata->City = $row['City'];
				  $userdata->State = $row['State'];
				  $userdata->Country = $row['Country'];
				  $userdata->Ethnicity = $row['Ethnicity'];
				  $userdata->Job = $row['Job'];
				  $userdata->Sexuality = $row['Sexuality'];
				  $userdata->Gender = $row['Gender'];
				  $userdata->Phone = $row['Phone'];
				  $userdata->logged = true;

				  
              }
              else{
                  $wrongpass = true;
                  //wrong password code goes here
				  $userdata->message = $userdata->message." Senha Errada";
              }
          }
          else{
              if($Count == $result->num_rows ){
              //user/email data incorrect code
			  $userdata->message = $userdata->message." Email ou login incorretos";
              }
            }
      }
      else{
		  //data validation
          if($userdata->Username == $row["Username"]){
              $userdata->userchecked = true; //user is in the database
          }
          if($userdata->Email == $row["Email"]){
              $userdata->emailchecked = true; // email is in the database
          }
        }
  }
 }
 //Creating account after data validation
if($userdata->Registering && $userdata->emailchecked == false && $userdata->userchecked == false){ //checks if user is registering, if email is registered and if username is taken
    $sql = "INSERT INTO accountdata (AccountID, email, username, password, First_Name, Last_Name, Account_Birth, Birthday, Zip_Code, City, State, Country, Ethnicity, Job, Sexuality, Gender, Phone)
    VALUES (0000+'count+1'+525, '$userdata->Email', '$userdata->Username', '$userdata->Password', '$userdata->Name', '$userdata->LName', '$userdata->Account_Birth', '$userdata->Birthday', '$userdata->Zip_Code', '$userdata->City', '$userdata->State', '$userdata->Country', '$userdata->Ethnicity', '$userdata->Job', '$userdata->Sexuality', '$userdata->Gender', '$userdata->Phone')";
            $result = $conn->query($sql); //Acquiring information into var
            $currentaccount = $userdata;
            //executing code
            $wrongpass = false;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $userdata->message = $userdata->message." Conta Criada!";
	  $userdata->AccountID = $row['AccountID'];
	  $userdata->Email = $row['Email'];
	  $userdata->Username = $row['Username'];
      $userdata->Password = $row['Password'];
	  $userdata->Name = $row['Name'];
	  $userdata->LName = $row['LName'];
      $userdata->Account_Birth = $$row['Account_Birth'];
      $userdata->Birthday = $$row['Birthday'];
      $userdata->Zip_Code  = $row['Zip_Code'];
      $userdata->City = $row['City'];
      $userdata->State = $row['State'];
      $userdata->Country = $row['Country'];
      $userdata->Ethnicity = $row['Ethnicity'];
      $userdata->Job = $row['Job'];
      $userdata->Sexuality = $row['Sexuality'];
      $userdata->Gender = $row['Gender'];
      $userdata->Phone = $row['Phone'];
	  $userdata->logged = true;
    }
}

    
}
else{
    if($userdata->emailchecked){
        $userdata->message = $userdata->message." Email is under use";
    }
    if($userdata->userchecked){
        $userdata->message = $userdata->message." Username taken";
    }
    
}

echo json_encode($userdata, JSON_FORCE_OBJECT); 
//$conn->close();
?>

