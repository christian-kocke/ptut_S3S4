<?php
include_once "../core/init.php";
$user = new user();
$db = db::getInstance();
$bdd = $db->getPDO();
if(input::exists()) { // test si la variable $_POST est set
    if(token::check(input::get('token_login'))) { // verifie que le token du formulaire est equivalent au token dans la variable session de l'utilisateur
        $validation = new validation(); // nouvelle instance de validation
        $validation = $validation->check($_POST, array( // validation des champs
            'login_username' => array('required' => true, 'error' => 'the username', 'numeric' => false), // critères de validation du champ username
            'login_password' => array('required' => true, 'error' => 'the password') // critères de validation du champ password
            ));
        if($validation->passed()) { // si les champs sont valider
            $user = new user(); // nouvelle instance utilisateur
            $remember = (input::get('remember') === 'on') ? true : false; // on regarde si l'utilisateur veut être retenue dans un cookie
            $login = $user->login(input::get('login_username'), input::get('login_password'), $remember); // connection de l'utilisateur

            if($login) { // si la connection à été effectuer
              redirect::to('index.php'); // redirection a la page d'accueil
          } else {
                session::flash('login', array('connection failed')); // sinon on notifie l'utilisateur que la connection a échoué
            }
        } else {
            session::flash('login', $validation->errors()); // si la validation n'a pas réussit on affiche les erreurs
        }
    }
}

// Validation des champ pour l'enregistrement de l'utilisateur

if (input::exists()) { // test si la variable $_POST est set
    if(token::check(input::get('token_register')) === true) { // verifie que le token du formulaire est equivalent au token dans la variable session de l'utilisateur
        $validate = new validation(); // nouvelle instance de validation
        $validation = $validate->check($_POST, array( // validation des champs
            'username' => array( // critères de validation du champ username
                'error' => 'the username',
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users',
                'numeric' => false
                ),
            'password' => array( // critères de validation du champ password n°1
                'error' => 'the password',
                'required' => true,
                'min' => 6,
                ),
            'password2' => array( // critères de validation du champ password n°2
                'error' => 'the second password',
                'required' => true,
                'matches' => 'password'
                ),
            'firstname' => array( // critères de validation du champ firstname
                'error' => 'the firstname',
                'required' => true,
                'min' => 2,
                'max' => 50
                ),
            'lastname' => array( // critère de validation du champ lastname
            	'error' => 'the lastname',
            	'required' => true,
            	'min' => 2,
                'max' => 50
                ),
            'email' => array(
            	'error' => "the email address",
            	'required' => true,
            	'min' => 4,
            	'max' => 40,
                ),
            'phone' => array(
            	'error' => "the phone number",
            	'required' => true,
            	'min' => 10,
            	'max' => 20,
            	'numeric' => true
                )
            ));

        if ($validation->passed()) { // si les champs sont valider
            $user = new user(); // nouvelle instance utilisateur
            $salt = hash::salt(32); // création d'un salt pour le hashage du mot de passe dans la base de donnée
            try { // try - catch pour les erreurs sql éventuel
                $user->create(array( // création de l'utilisateur
                    'username' => input::get('username'),
                    'password' => hash::generate(input::get('password'), $salt), // hashage du mot de passe en 'sha256' avec un salt
                    'salt' => $salt,
                    'firstname' => input::get('firstname'),
                    'lastname' => input::get('lastname'),
                    'phone' => input::get('phone'),
                    'email' => input::get('email'),
                    'joined' => date('Y-m-d H:i:s'), // date de la création de l'utilisateur
                    'user_group' => 1 // sont groupe (admin, user, etc ...)
                    ));
                session::flash('home', 'You registered successfully !'); // on affiche le message pour signaler a l'utilisateur qu'il a bien été enregistrer
                redirect::to('index.php'); // on le redirige a la page d'accueil

            } catch(Exception $e) { 
                die($e->getMessage()); // affichage des erreurs eventuelles
            }
        } else {
            session::flash('register', $validation->errors()); // si la validation des champs échoue on affiche les erreurs
        }
    }
}

$token = token::generate(); // on génère le token pour éviter les 'cross site forgeries'

include_once "head.php";
?>
<div class="small-12 large-12 columns background parts">
    <div class="row">
        <h3 class="subheader text-center t1"> Bienvenue sur </h3> 
        <h1 class="subheader text-center t2"> Le Restaurant </h1>
    </div><!-- class row -->
    <div class="arrowContainer">
        <a href="#suite"><img src="assets/img/down.png" alt="downarrow"></a>
    </div><!-- class arrowContainer -->
</div><!-- class small-12 large-12 columns background parts -->

<div class="small-12 large-12 columns menu parts exception">
    <h1 class="subheader text-center t2"> Le Menu </h1>
 <?php
 $reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM entree ');

 echo '<h2>Entrée</h2></br>';
 while ($donnees = $reponse->fetch())
 {
    if($donnees['disponible']==1) {
        echo '<strong>' .  $donnees['nom'] . '</strong>' . '<br />' . $donnees['ingredient']   . '<h4>' . $donnees['prix']  . ' €' . '</h4>' . '<br/>*' . '<br /> <br />';
    }
}
$reponse->closeCursor();

$reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM plat ');

echo '<h2>Plat</h2></br>';
while ($donnees = $reponse->fetch())
{
    if($donnees['disponible']==1) {
        echo '<strong>' . $donnees['nom'] . '</strong> '. '<br />'  . $donnees['ingredient']  . '<h4>' . $donnees['prix'] . ' €' . '</h4>' . '<br/>*' . '<br /> <br />';
    }
}

$reponse->closeCursor();



$reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM dessert ');

echo '<h2>Dessert</h2></br>';
while ($donnees = $reponse->fetch())
{
    if($donnees['disponible']==1) {
        echo '<strong>' . $donnees['nom'] . '</strong>' . '<br />'  .  $donnees['ingredient']   . '<h4>' . $donnees['prix'] . ' €' . '</h4>' . '<br/>*'. '<br /> <br />';
    }
}	

$reponse->closeCursor();

?>
</div><!-- class small-12 large-12 columns menu parts -->

<div class="small-12 large-12 columns chef parts exception">
    <div class="row">
        <div class="small-12 large-12 columns" data-equalizer>
            <h1 class="subheader text-center t2"> L'équipe du restaurant </h1>
            
            <!-- DESCRIPTION CHEF -->
            <div class="small-12 large-4 columns">
                <div class="panel text-center" data-equalizer-watch>
                    <h3 class="subheader text-center"> Chef Yann </h3>
                    <img src="assets/img/photochef.jpg" alt="View">
                    <p> Me patriam ipsi) atque publicam credite dimicatione cum cum Caesare reducit rem reconciliat quodam rursum universis existimatis subire Caesare et impendentibus maximis subire et restituit pristinus dimicatione olim ipsi) et amor meus perennis dimicatione coegit esse subvenire me me facitis.</p>
                </div><!-- class panel text-center -->
            </div><!-- class small-12 large-4 columns -->

            <!-- DESCRIPTION CHEF -->
            <div class="small-12 large-4 columns">
                <div class="panel text-center" data-equalizer-watch>
                    <h3 class="subheader text-center"> Esclave Christian </h3>
                    <img src="assets/img/photochef.jpg" alt="View">
                    <p> Me patriam ipsi) atque publicam credite dimicatione cum cum Caesare reducit rem reconciliat quodam rursum universis existimatis subire Caesare et impendentibus maximis subire et restituit pristinus dimicatione olim ipsi) et amor meus perennis dimicatione coegit esse subvenire me me facitis.</p>
                </div><!-- class panel text-center -->
            </div><!-- class small-12 large-4 columns -->

            <!-- DESCRIPTION CHEF -->
            <div class="small-12 large-4 columns">
                <div class="panel text-center" data-equalizer-watch>
                    <h3 class="subheader text-center"> Esclave Noé </h3>
                    <img src="assets/img/photochef.jpg" alt="View">
                    <p> Me patriam ipsi) atque publicam credite dimicatione cum cum Caesare reducit rem reconciliat quodam rursum universis existimatis subire Caesare et impendentibus maximis subire et restituit pristinus dimicatione olim ipsi) et amor meus perennis dimicatione coegit esse subvenire me me facitis.</p>
                </div><!-- class panel text-center -->
            </div><!-- class small-12 large-4 columns -->

        </div><!-- class small-12 large-12 columns -->
    </div><!-- class row -->
</div><!-- class small-12 large-12 columns chef parts -->
<?php
include_once 'footer.php';
?>

