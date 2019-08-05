<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
header('Content-Type: text/html; charset=utf-8');
?>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<link rel="stylesheet" href="dist/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="dist/js/bootstrap-multiselect.js"></script>
<title> Comparateur de formation BAFA</title>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Roboto">



<!------ Include the above in your HEAD tag ---------->

<?php                                       $servername = "localhost";
                                            $username = "root";
                                            $password = "root";
                                            
                                            // Create connection
                                            $mysqli = new mysqli($servername, $username, $password, "bafa");
                                            if ($mysqli->connect_errno) {
                                                echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                                            }

                                            /* Modification du jeu de résultats en utf8 */
                                            if (!mysqli_set_charset($mysqli, "utf8")) {
                                                printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", mysqli_error($mysqli));
                                                exit();
                                            }
                                            
?>


<style>
      body {
        font-family: 'Roboto', serif;

      }
      h1, h2, h3, h4, h5, h6 {
        font-family: 'Roboto', serif;
            }
.dropdown.dropdown-lg .dropdown-menu {
    margin-top: -1px;
    padding: 6px 20px;
}
.input-group-btn .btn-group {
    display: flex !important;
}
.btn-group .btn {
    border-radius: 0;
    margin-left: -1px;
}
.btn-group .btn:last-child {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}
.btn-group .form-horizontal .btn[type="submit"] {
  border-top-left-radius: 4px;
  border-bottom-left-radius: 4px;
}
.form-horizontal .form-group {
    margin-left: 0;
    margin-right: 0;
}
.form-group .form-control:last-child {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}

@media screen and (min-width: 768px) {
    #adv-search {
        width: 500px;
        margin: 0 auto;
    }
    .dropdown.dropdown-lg {
        position: static !important;
    }
    .dropdown.dropdown-lg .dropdown-menu {
        min-width: 500px;
    }
}
#hover-content {
    display:none;
}
#parent:hover #hover-content {
    display:block;
}
.bg {

  background: url('https://source.unsplash.com/twukN12EN7c/1920x1080') no-repeat center center fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  background-size: cover;
  -o-background-size: cover;

}
</style>


<div class="container">
	<div class="row">
        
		<div class="col-md-12">
        <h3>Comparateur de formation BAFA en Loire-Atlantique</h3>
        <br/>
        <br/>
                               <form class="form-horizontal" role="form" method="post">
                                  <div class="form-group">

                                      <script type="text/javascript">
                                        $(document).ready(function() {
                                            $('#villeChoix').multiselect({
                                            includeSelectAllOption: true,
                                            buttonWidth: 950,
                                            enableFiltering: true
                                        });
                                        });
                                    </script>
                                     <label for="contain">Ville</label><br/>
                                     <select id="villeChoix" name="ville[]" multiple="multiple">

                                     <?php 

                                            //Remplir Lieu
                                            $res = $mysqli->query("SELECT DISTINCT(Lieu) FROM bafaComp ORDER BY Lieu DESC");

                                            while ($row = $res->fetch_assoc()) {
                                              echo '<option value="' . $row['Lieu'] . '">' . $row['Lieu'] . '</option>';
                                              echo $row['Lieu'];
                                            }
                                            ?>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                      <script type="text/javascript">
                                        $(document).ready(function() {
                                            $('#typeFormation').multiselect({
                                            includeSelectAllOption: true,
                                            buttonWidth: 950,
                                            enableFiltering: true,
                                            onChange: function(element, checked) {
                                            var brands = $('#typeFormation option:selected');
                                            var selecteds = [];
                                            $(brands).each(function(index, brand){
                                                selecteds.push([$(this).val()]);
                                            });

                                            console.log(selecteds);
                                        }
                                        });
                                        });
                                    </script>
                                     <label for="contain">Type de formation</label><br/>
                                     <select id="typeFormation" name="typeformation[]" multiple="multiple">
                                            <option value="General">Général</option>
                                            <option value="Approfondissement">Approfondissement</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="contain">Date</label><br/>
                                    <input type="text" name="daterange" value="01/01/2018 - 01/15/2031" />

                                    <script>
                                    $(function() {
                                      $('input[name="daterange"]').daterangepicker({
                                        opens: 'left'
                                      }, function(start, end, label) {
                                        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                                      });
                                    });
                                    </script>
                                  </div>
                                  <div class="form-group">
                                      <script type="text/javascript">
                                        $(document).ready(function() {
                                            $('#boot-multiselect-demo').multiselect({
                                            includeSelectAllOption: true,
                                            buttonWidth: 950,
                                            enableFiltering: true,
                                            onChange: function(element, checked) {
                                            var brands = $('#boot-multiselect-demo option:selected');
                                            var selected = [];
                                            $(brands).each(function(index, brand){
                                                selected.push([$(this).val()]);
                                            });

                                            console.log(selected);
                                        }
                                        });
                                        });
                                    </script>
                                     <label for="contain">Thèmes</label><br/>
                                     <select id="boot-multiselect-demo" name="theme[]" multiple="multiple">

                                     <?php 

                                            //Remplir Lieu
                                            $res = $mysqli->query("SELECT DISTINCT(Themes) FROM bafaComp ORDER BY Lieu DESC");

                                            while ($row = $res->fetch_assoc()) {
                                              echo '<option value="' . $row['Themes'] . '">' . $row['Themes'] . '</option>';
                                              echo $row['Themes'];
                                            }
                                            ?>
                                    </select>
                                  </div>
                                    <div class="form-group">

                                        <script type="text/javascript">
                                          $(document).ready(function() {
                                              $('#accueilChoix').multiselect({
                                              includeSelectAllOption: true,
                                              buttonWidth: 950,
                                              enableFiltering: true
                                          });
                                          });
                                      </script>
                                       <label for="contain">Accueil</label><br/>
                                       <select id="accueilChoix" name="accueil[]" multiple="multiple">
                                              <option value="Internat">Internat</option>
                                              <option value="Externat">Externat</option>
                                              <option value="Demi-pension">Demi-pension</option>
                                      </select>

                                    </div>
                                    
                                  <button type="submit" name="submit" class="btn btn-primary" value=Submit><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                </form>

        </div>
	</div>
</div>

<?php 
    $query = "SELECT * FROM bafaComp WHERE ";
    


    // Check if form is submitted successfully 
    if(isset($_POST["submit"]))  
    { 
        $query = $query . " 1 = 1 ";
        // Check if any option is selected 
        if(isset($_POST["theme"]))  
        { 
            $query = $query . " AND Themes LIKE '%";
            $i = 0;
            foreach ($_POST['theme'] as $subject)  {
                if ($i == 0){
                    $query = $query . $subject . "%' ";

                }
                else{
                    $query = $query . " OR Themes LIKE '%" . $subject . "%'" . " ";
                }
                $i = $i + 1;
                
            }
                            
        } 
        if(isset($_POST["accueil"]))  
        { 
            $query = $query . " AND ( Accueil LIKE '%";
            $i = 0;
            foreach ($_POST['accueil'] as $subject)  {
                if ($i == 0){
                    $query = $query . $subject . "%' ";
                   
                }
                else{
                    $query = $query . " OR Accueil LIKE '%" . $subject . "%'" . " ";
                }
                $i = $i + 1;
                
            }
            $query = $query . ")";
                            
        } 

        if(isset($_POST["daterange"]))  
        { 
            $dateDebutStr = substr($_POST["daterange"], 0, 10);
            $dateFinStr = substr($_POST["daterange"], 13, 10);
            
            $query = $query . " AND dateDebut > STR_TO_DATE('" . $dateDebutStr . "', '%m/%d/%Y') AND  dateFin < STR_TO_DATE('" . $dateFinStr . "', '%m/%d/%Y') ";
        } 


        if(isset($_POST["ville"]))  
        { 
            $query = $query . " AND Lieu LIKE '%";
            $i = 0;
            foreach ($_POST['ville'] as $subject)  {
                if ($i == 0){
                    $query = $query . $subject . "%' ";

                }
                else{
                    $query = $query . " OR Lieu LIKE '%" . $subject . "%'" . " ";
                }
                $i = $i + 1;
                
            }

                            
        } 
        $res = $mysqli->query($query);

        $i=0;
        while ($row = $res->fetch_assoc()) {
            if ($i == 0){
                echo '<br/>';
                echo '<br/>';
               
                echo '<div class="container">';
                echo '<div class="row">';
                echo '<h3>Résultats de la recherche</h3>';
                echo '<br/>';
                echo '<br/>';
                echo "<table class='table'>";
                echo "<thead>";
                echo "<tr>";
                echo '<th scope="col">Date début</th>';
                echo '<th scope="col">Date Fin</th>';
                echo '<th scope="col">Thème</th>';
                echo '<th scope="col">Lieu</th>';
                echo '<th scope="col">Accueil</th>';
                echo '<th scope="col">En savoir plus</th>';
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
            }
            echo "<tr>";
            $p = 0;
            foreach ($row as $value) {
                if ($p < sizeof($row) - 1){
                    if (strlen($value)>20){
                        echo '<td>';
                        echo '<div id="parent">';
                        echo  substr($value, 0, 20) . "...";
                        echo '<div id="hover-content">';
                        echo $value;
                        echo '</div>';
                        echo '</div>';
                        echo '</td>';
                    }
                    else{
                        echo "<td>" . $value . "</td>";
                    }
                    
                }
                else{

                   echo  '<td><a class="btn btn-primary" href="'. $value . '" role="button">En savoir plus</a></td>';
                }
                $p = $p+1;
            }
            
            echo "</tr>";
            $i = $i + 1;
        }
        echo "</tbody>";
        echo "</table>";

        

    }


?> 

