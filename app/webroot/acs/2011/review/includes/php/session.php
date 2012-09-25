<?

include_once('db.php');
init();

function loginRequired() {
  // if not logged in, send them back to the login page
  if(!isLoggedIn())
    header('Location: ../');
}

function logout() {
  // logs a user out of the session completely
  session_destroy();
  header('Location: ../');
}

function adminRequired() {
  // if not admin, send them back to the main page
  if(!isAdmin())
    header('Location: ../');
}

function isAdmin() {
  // check whether the user is an admin
  return $_SESSION['userIsAdmin'] == true;
}

function isReviewer() {
  // check whether the user is a reviewer
  return $_SESSION['userIsReviewer'] == true;
}

function isMember() {
  // check whether user is a member of the program committee
  $ids = array(6, 35, 36, 37, 38, 41, 36, 42, 39, 1);
  $flip = array_flip($ids);
  $id = $_SESSION['userID'];
  
  return(isset($flip[$id]));
}

function isLoggedIn() {
  // return true if there is a logged in user; otherwise, return false
  return $_SESSION['loggedIn'] == true;
}

function checkLogin($email, $password) {
  // checks to see whether the supplied information is a valid login
  $q = 'SELECT * FROM user WHERE email=:email AND ' .
    'password=:password';
    
  $arr = array(':email'=>$email, ':password'=>$password);
  
  $r = pQuery($q, $arr);
  
  if(sizeof($r) > 0) {
    doLogin($r[0]);
  } else {
    header('Location: ../');
  }
}

function doLogin($row) {
  // set all session vars here when given a row from the database
  $name = $row['name'] . ' ' . $row['surname'];
  $email = $row['email'];
  $isAdmin = ($row['isAdmin'] == 1);
  $isReviewer = ($row['isReviewer'] == 1);
  $id = $row['id'];
  
  $_SESSION['userID'] = $id;
  $_SESSION['userName'] = $name;
  $_SESSION['userEmail'] = $email;
  $_SESSION['userIsAdmin'] = $isAdmin;
  $_SESSION['userIsReviewer'] = $isReviewer;
  $_SESSION['loggedIn'] = true;
  
  goHome();
}

function goHome() {
  // takes a user to the right home page  
  if(isLoggedIn()) {
    if($_SESSION['userIsAdmin'] == true) {
      header('Location: ../admin/');
    } else {
      header('Location: ../home/');
    }
  }
}

function adminMenu() {
  printf('<a href="../manage/">Manage Reviewers</a>');
  printf('<a href="../assign/">Manage Papers</a>');
  printf('<a href="../reviews/">View Reviews</a>');
  printf('<a href="../paper-category/assign.php">Assign Category</a>');
  reviewerMenu();
}

function reviewerMenu() {
  printf('<a href="../home/">View Papers</a>');
  if(isMember())
    printf('<a href="../paper-category/">View Paper Categorizations</a>');
  //printf('<a href="../review-form/">Review Form</a>');
}

function menu() {
  if(isAdmin())
    adminMenu();
  else
    reviewerMenu();
}

function passwordResetRequired() {
  // returns true if the user needs to reset their password; 
  // false otherwise
  $id = $_SESSION['userID'];
  $q = 'SELECT * FROM reset_password WHERE user=:id';
  $r = pQuery($q, array(':id'=>$id));
  return sizeof($r)!=0;
}

function generatePassword($length = 8) {
    // start with a blank password
    $password = "";
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
    $maxlength = strlen($possible);
  
    // check for length overflow and truncate if necessary
    if ($length > $maxlength)
      $length = $maxlength;

    $i = 0; 
    
    while ($i < $length) { 

      // pick a random character from the possible ones
      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
        
      // have we already used this character in $password?
      if (!strstr($password, $char)) { 
        $password .= $char;
        $i++;
      }
    }
    return $password;
  }
?>