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
/* 
  You want a simple and fancy tooltip?
  Just copy all [data-tooltip] blocks:
*/
[data-tooltip] {
  position: relative;
  z-index: 10;
}

/* Positioning and visibility settings of the tooltip */
[data-tooltip]:before,
[data-tooltip]:after {
  position: absolute;
  visibility: hidden;
  opacity: 0;
  left: 50%;
  bottom: calc(100% + 5px);
  pointer-events: none;
  transition: 0.2s;
  will-change: transform;
}

/* The actual tooltip with a dynamic width */
[data-tooltip]:before {
  content: attr(data-tooltip);
  padding: 10px 18px;
  min-width: 50px;
  max-width: 300px;
  width: max-content;
  width: -moz-max-content;
  border-radius: 6px;
  font-size: 14px;
  background-color: rgba(59, 72, 80, 0.9);
  background-image: linear-gradient(30deg,
    rgba(59, 72, 80, 0.44),
    rgba(59, 68, 75, 0.44),
    rgba(60, 82, 88, 0.44));
  box-shadow: 0px 0px 24px rgba(0, 0, 0, 0.2);
  color: #fff;
  text-align: center;
  white-space: pre-wrap;
  transform: translate(-50%, -5px) scale(0.5);
}

/* Tooltip arrow */
[data-tooltip]:after {
  content: '';
  border-style: solid;
  border-width: 5px 5px 0px 5px;
  border-color: rgba(55, 64, 70, 0.9) transparent transparent transparent;
  transition-duration: 0s; /* If the mouse leaves the element, 
                              the transition effects for the 
                              tooltip arrow are "turned off" */
  transform-origin: top;   /* Orientation setting for the
                              slide-down effect */
  transform: translateX(-50%) scaleY(0);
}

/* Tooltip becomes visible at hover */
[data-tooltip]:hover:before,
[data-tooltip]:hover:after {
  visibility: visible;
  opacity: 1;
}
/* Scales from 0.5 to 1 -> grow effect */
[data-tooltip]:hover:before {
  transition-delay: 0.3s;
  transform: translate(-50%, -5px) scale(1);
}
/* Slide down effect only on mouseenter (NOT on mouseleave) */
[data-tooltip]:hover:after {
  transition-delay: 0.5s; /* Starting after the grow effect */
  transition-duration: 0.2s;
  transform: translateX(-50%) scaleY(1);
}
/*
  That's it.
*/







/*
  If you want some adjustability
  here are some orientation settings you can use:
*/

/* LEFT */
/* Tooltip + arrow */
[data-tooltip-location="left"]:before,
[data-tooltip-location="left"]:after {
  left: auto;
  right: calc(100% + 5px);
  bottom: 50%;
}

/* Tooltip */
[data-tooltip-location="left"]:before {
  transform: translate(-5px, 50%) scale(0.5);
}
[data-tooltip-location="left"]:hover:before {
  transform: translate(-5px, 50%) scale(1);
}

/* Arrow */
[data-tooltip-location="left"]:after {
  border-width: 5px 0px 5px 5px;
  border-color: transparent transparent transparent rgba(55, 64, 70, 0.9);
  transform-origin: left;
  transform: translateY(50%) scaleX(0);
}
[data-tooltip-location="left"]:hover:after {
  transform: translateY(50%) scaleX(1);
}



/* RIGHT */
[data-tooltip-location="right"]:before,
[data-tooltip-location="right"]:after {
  left: calc(100% + 5px);
  bottom: 50%;
}

[data-tooltip-location="right"]:before {
  transform: translate(5px, 50%) scale(0.5);
}
[data-tooltip-location="right"]:hover:before {
  transform: translate(5px, 50%) scale(1);
}

[data-tooltip-location="right"]:after {
  border-width: 5px 5px 5px 0px;
  border-color: transparent rgba(55, 64, 70, 0.9) transparent transparent;
  transform-origin: right;
  transform: translateY(50%) scaleX(0);
}
[data-tooltip-location="right"]:hover:after {
  transform: translateY(50%) scaleX(1);
}



/* BOTTOM */
[data-tooltip-location="bottom"]:before,
[data-tooltip-location="bottom"]:after {
  top: calc(100% + 5px);
  bottom: auto;
}

[data-tooltip-location="bottom"]:before {
  transform: translate(-50%, 5px) scale(0.5);
}
[data-tooltip-location="bottom"]:hover:before {
  transform: translate(-50%, 5px) scale(1);
}

[data-tooltip-location="bottom"]:after {
  border-width: 0px 5px 5px 5px;
  border-color: transparent transparent rgba(55, 64, 70, 0.9) transparent;
  transform-origin: bottom;
}











@keyframes moveFocus { 
  0%   { background-position: 0% 100% }
  100% { background-position: 100% 0% }
}

body {
  background: none;
}

main {
  padding: 4%;
  display: flex;
  flex-direction: row;
}

button {
  margin: 0;
  padding: 0.7rem 1.4rem;

  cursor: pointer;
  text-align: center;
  border: none;
  border-radius: 4px;
  outline: inherit;
  text-decoration: none;
  font-family: Roboto, sans-serif;
  font-size: 0.7em;

}
button:hover {
  background-color: #484f56;
}
button:active {
  transform: scale(0.98);
}
button:focus {
  box-shadow: 0 0 2px 2px #298bcf;
}
button::-moz-focus-inner {
  border: 0;
}

.example-elements {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  align-content: center;
  justify-content: center;
  text-align: center;
  padding-right: 4%;
}

.example-elements p {
  padding: 6px;
  display: inline-block;
  margin-bottom: 5%;
}
.example-elements p:hover {
  border-left: 1px solid lightgrey;
  border-right: 1px solid lightgrey;
  padding-left: 5px;
  padding-right: 5px;
}

.example-elements a {
  margin-left: 6px;
  margin-bottom: calc(5% + 10px);
  color: #76daff;
  text-decoration: none;
}
.example-elements a:hover {
  margin-bottom: calc(5% + 9px);
  border-bottom: 1px solid #76daff;
}

.example-elements button {
  margin-bottom: 20px;
}

.info-wrapper {
  flex-grow: 8;
  display: flex;
  flex-direction: column;
  justify-content: center;
  text-align: justify;
  padding-left: 6%;
  border-left: 3px solid #35ea95;
}

.info-wrapper p {
  color: rgba(255, 255, 255, 0.69);
}
.info-wrapper p {
  max-width: 600px;
  text-align: justify;
}

.info-wrapper .title-question {
  display: block;
  color: #fff;
  font-size: 1.36em;
  font-weight: 500;
  padding-bottom: 24px;
}


/* Thumbnail settings */
@media (max-width: 800px) {
  html {
/*     box-shadow: inset 0px -13px 0px -7px #0ebeff; */
    animation-duration: 0.6s;
  }
  body {
    display: flex;
    background: none;
    height: 100%;
    margin: 0px;
  }
  main {
    font-size: 1.1em;
    padding: 6%;
  }
  .info-wrapper p:before,
  .info-wrapper p:after {
    display: none;
  }
  .example-elements {
    max-width: 150px;
    font-size: 22px;
  }
  .example-elements a, button {
    display: none;
  }
  .example-elements p:before, 
  .example-elements p:after {
    visibility: visible;
    opacity: 1;
  }
  .example-elements p:before {
    content: "Tooltip";
    font-size: 20px;
    transform: translate(-50%, -5px) scale(1);
  }
  .example-elements p:after {
    transform: translate(-50%, -1px) scaleY(1);
  }
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
                                              echo '<option value="' . str_replace(" ","",$row['Lieu']) . '">' .  str_replace(" ","",$row['Lieu']) . '</option>';
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
            $query = $query . ' AND Themes LIKE "%';
            $i = 0;
            foreach ($_POST['theme'] as $subject)  {
                if ($i == 0){
                    $query = $query . $subject . '%" ';

                }
                else{
                    $query = $query . ' OR Themes LIKE "%' . $subject . '%"' . ' ' ;
                }
                $i = $i + 1;
                
            }
                            
        } 
        if(isset($_POST["accueil"]))  
        { 
            $query = $query . ' AND Accueil LIKE "%';
            $i = 0;
            foreach ($_POST['accueil'] as $subject)  {
                if ($i == 0){
                    $query = $query . $subject . '%" ';
                   
                }
                else{
                    $query = $query . ' OR Accueil LIKE "%' . $subject . '%"' . ' ' ;
                }
                $i = $i + 1;
                
            }

                            
        } 

        if(isset($_POST["daterange"]))  
        { 
            $dateDebutStr = substr($_POST["daterange"], 0, 10);
            $dateFinStr = substr($_POST["daterange"], 13, 10);
            
            $query = $query . " AND dateDebut > STR_TO_DATE('" . $dateDebutStr . "', '%m/%d/%Y') AND  dateFin < STR_TO_DATE('" . $dateFinStr . "', '%m/%d/%Y') ";
        } 


        if(isset($_POST["ville"]))  
        { 
            $query = $query . ' AND Lieu LIKE "%';
            $i = 0;
            foreach ($_POST['ville'] as $subject)  {
                if ($i == 0){
                    $query = $query . $subject . '%" ';

                }
                else{
                    $query = $query . ' OR Lieu LIKE "%' . $subject . '%"' . ' ' ;
                }
                $i = $i + 1;
                
            }

                            
        } 
 
        $res = $mysqli->query($query . " ORDER BY Lieu ASC");

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
                        echo '<p data-tooltip="' . $value . '">';
                        echo  substr($value, 0, 20) . "...";
                        echo '</p>';
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

