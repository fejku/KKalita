<?php
    require './top.php';
?>
<?php
    $submitted_username = '';
    
    if(!empty($_POST))
    {
        $query = "
            SELECT
                username,
                password,
                salt
            FROM users
            WHERE
                username = :username
        ";
        
        $query_params = array(
            ':username' => $_POST['username']
        );
        
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }
        
        $login_ok = false;
        
        $row = $stmt->fetch();
        if($row)
        {
            $check_password = hash('sha256', $_POST['password'] . $row['salt']);
            for($round = 0; $round < 65536; $round++)
            {
                $check_password = hash('sha256', $check_password . $row['salt']);
            }
            
            if($check_password === $row['password'])
            {
                $login_ok = true;
            }
        }
        
        if($login_ok)
        {
            unset($row['salt']);
            unset($row['password']);
            
            $_SESSION['user'] = $row;
            
            
            if(empty($_POST['skad']))
            {
                header("Location: index.php");
                die("Redirecting to: index.php");
            }
            else 
            {
                header("Location: ".$_POST['skad']);
                die("Redirecting to: ".$_POST['skad']);
            }
        }
        else
        {
            print("Login Failed.");

            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
        }
    }
    
?>
<div class="wysrodkuj">
<h1>Login</h1>
<form action="login.php" method="post">
    Username:<br />
    <input type="text" name="username" value="<?php echo $submitted_username; ?>" />
    <br /><br />
    Password:<br />
    <input type="password" name="password" value="" />
    <br /><br />
    <input type="submit" value="Login" />
    <input type="hidden" name="skad" value="<?php if(isset($_GET['skad'])) echo $_GET['skad'] ?>">
</form>
<a href="register.php">Register</a>
</div>
<?php
    include './bottom.php';
?>