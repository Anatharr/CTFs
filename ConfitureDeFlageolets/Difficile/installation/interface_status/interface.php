<html>
    <head>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    </head>
    <body>
        <div id="container">
            <!-- zone de connexion -->
            
            <form action="status.php" method="get">
                <h1>Cameras' status</h1>
                
                <label><b>Camera's name</b></label>
                <input type="text" placeholder="Enter the camera's name" name="camera_name" required>

                <label><b>Password</b></label>
                <input type="password" placeholder="Enter your password" name="password" required>

                <input type="submit" id='submit' value='Get status' >
                <!-- <?php
                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2)
                        echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
                }
                ?> -->

                
            </form>
        </div>
    </body>