<?php
include_once "../core/init.php";
$user = new user();
$db = db::getInstance();
$bdd = $db->getPDO();
if(input::exists()) { // test si la variable $_POST est set
    if(token::check(input::get('token_login'))) { // verifie que le token du formulaire est equivalent au token dans la variable session de l'utilisateur
        $validation = new validation(); // nouvelle instance de validation
        $validation = $validation->check($_POST, array( // validation des champs
            'login_username' => array('required' => true, 'error' => "le nom d'utilisateur", 'numeric' => false), // critères de validation du champ username
            'login_password' => array('required' => true, 'error' => 'le mot de passe') // critères de validation du champ password
            ));
        if($validation->passed()) { // si les champs sont valider
            $user = new user(); // nouvelle instance utilisateur
            $remember = (input::get('remember') === 'on') ? true : false; // on regarde si l'utilisateur veut être retenue dans un cookie
            $login = $user->login(input::get('login_username'), input::get('login_password'), $remember); // connection de l'utilisateur

            if($login) { // si la connection à été effectuer
                session::flash('home', "Bienvenue ".$user->data()->username);
                redirect::to('index.php'); // redirection a la page d'accueil
            } else {
                session::flash('login', array('Echec de la connection')); // sinon on notifie l'utilisateur que la connection a échoué
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
                'error' => "le nom d'utilisateur",
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users',
                'numeric' => false
                ),
            'password' => array( // critères de validation du champ password n°1
                'error' => "le mot de passe",
                'required' => true,
                'min' => 6,
                ),
            'password2' => array( // critères de validation du champ password n°2
                'error' => "le second mot de passe",
                'required' => true,
                'matches' => 'password'
                ),
            'firstname' => array( // critères de validation du champ firstname
                'error' => "le prénom",
                'required' => true,
                'min' => 2,
                'max' => 50
                ),
            'lastname' => array( // critère de validation du champ lastname
            	'error' => "le nom",
            	'required' => true,
            	'min' => 2,
                'max' => 50
                ),
            'email' => array(
            	'error' => "l'email",
            	'required' => true,
            	'min' => 4,
            	'max' => 40,
                'unique' => 'users'
                ),
            'phone' => array(
            	'error' => "le numéro de téléphone",
            	'required' => true,
            	'min' => 10,
            	'max' => 20,
            	'numeric' => true,
                'unique' => 'users'
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
                session::flash('home', 'Inscription réussite, Bienvenue sur Le Restaurant !'); // on affiche le message pour signaler a l'utilisateur qu'il a bien été enregistrer
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
<!-- Alert d'erreur login -->
<div id="mainAlert4" data-alert class="alert-box success hide large-7 medium-6 small-5 large-centred medium-centered small-centered column text-center" tabindex="0" aria-live="assertive" role="dialogalert">
    <p class="flash"><?php
    if(session::exists('home')){
        echo session::flash('home').'</br>';
    }
    ?></p>
    <button href="#" tabindex="0" class="close" aria-label="Close Alert">&times;</button>
</div>


<div class="small-12 large-12 columns parts">

    <ul class="example-orbit" data-orbit>
        <li>
            <div class="small-12 large-12 columns background parts"></div>
        </li>
        <li class="active">
            <div class="small-12 large-12 columns fond2 parts"></div>
        </li>
        <li>
            <div class="small-12 large-12 columns fond3 parts"></div>
        </li>
    </ul>
    <ul data-orbit data-options="animation:slide; pause_on_hover:true; animation_speed:500; navigation_arrows:true; bullets:false;"></ul>

    <div class="small-12 large-12 text-center columns slider">
        <h3 class="subheader text-center t1"> Bienvenue sur </h3> 
        <h1 class="subheader text-center t2"> Le Restaurant </h1>
    </div><!-- class row -->

    <div class="arrowContainer">
        <a href="#suite"><img src="assets/img/down.png" alt="downarrow"></a>
    </div><!-- class arrowContainer -->

</div><!-- class small-12 large-12 columns background parts -->

<div class="row">
    <div class="small-12 large-12 columns menu exception" data-equalizer>
        <h1 id="suite" class="subheader text-center t2"> Le Menu </h1>
        <div class="small-12 large-4 columns">

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

            ?>
        </div>
        <div class="small-12 large-4 columns">
            <?php

            $reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM plat ');

            echo '<h2>Plat</h2></br>';
            while ($donnees = $reponse->fetch())
            {
                if($donnees['disponible']==1) {
                    echo '<strong>' . $donnees['nom'] . '</strong> '. '<br />'  . $donnees['ingredient']  . '<h4>' . $donnees['prix'] . ' €' . '</h4>' . '<br/>*' . '<br /> <br />';
                }
            }

            $reponse->closeCursor();

            ?>
        </div>
        <div class="small-12 large-4 columns">
            <?php



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
        </div>
    </div>

</div><!-- class small-12 large-12 columns menu parts -->

<div class="small-12 large-12 columns chef parts exception">
    <div class="row">
        <div class="small-12 large-12 columns" data-equalizer>
            <h1 class="subheader text-center t2"> L'équipe du restaurant </h1>

            <!-- DESCRIPTION CHEF -->
            <div class="small-12 large-4 columns t3">
                <div class="panel text-center" data-equalizer-watch>
                    <h3 class="subheader text-center"> Chef Yann </h3>
                    <img src="assets/img/photochef.jpg" alt="View">
                    <p> Me patriam ipsi) atque publicam credite dimicatione cum cum Caesare reducit rem reconciliat quodam rursum universis existimatis subire Caesare et impendentibus maximis subire et restituit pristinus dimicatione olim ipsi) et amor meus perennis dimicatione coegit esse subvenire me me facitis.</p>
                </div><!-- class panel text-center -->
            </div><!-- class small-12 large-4 columns -->

            <!-- DESCRIPTION CHEF -->
            <div class="small-12 large-4 columns t3">
                <div class="panel text-center" data-equalizer-watch>
                    <h3 class="subheader text-center"> Cusinier Christian </h3>
                    <img src="assets/img/photochef.jpg" alt="View">
                    <p> Me patriam ipsi) atque publicam credite dimicatione cum cum Caesare reducit rem reconciliat quodam rursum universis existimatis subire Caesare et impendentibus maximis subire et restituit pristinus dimicatione olim ipsi) et amor meus perennis dimicatione coegit esse subvenire me me facitis.</p>
                </div><!-- class panel text-center -->
            </div><!-- class small-12 large-4 columns -->

            <!-- DESCRIPTION CHEF -->
            <div class="small-12 large-4 columns t3">
                <div class="panel text-center" data-equalizer-watch>
                    <h3 class="subheader text-center"> Serveur Noé </h3>
                    <img src="assets/img/photochef.jpg" alt="View">
                    <p> Me patriam ipsi) atque publicam credite dimicatione cum cum Caesare reducit rem reconciliat quodam rursum universis existimatis subire Caesare et impendentibus maximis subire et restituit pristinus dimicatione olim ipsi) et amor meus perennis dimicatione coegit esse subvenire me me facitis.</p>
                </div><!-- class panel text-center -->
            </div><!-- class small-12 large-4 columns -->

        </div><!-- class small-12 large-12 columns -->
    </div><!-- class row -->
</div><!-- class small-12 large-12 columns chef parts -->

<div class="small-12 large-12 columns contact parts exception">
    <h1 class="subheader text-center t2"> Contact </h1>
    <div class="row" data-equalizer>
        <div class="small-12 large-6 columns">
            <div class="panel text-center " data-equalizer-watch >
                <h2 class="subheader text-center t3"> Nous écrire </h2>
                <form class="t3 emailForm" id="emailForm">
                    <input type="text" name="name" placeholder="Nom"/>
                    <input type="email" name="email" placeholder="Email"/>
                    <input type="text" name="subject" placeholder="Objet"/>
                    <textarea  rows="10" name="message" placeholder="Message..."></textarea>
                    <button class="button"><i class="fa fa-paper-plane"></i> Envoyer</button>
                </form>
            </div>
        </div>
        <div class="small-12 large-6 columns">
            <div class="panel text-center" data-equalizer-watch>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11129.88006909465!2d4.873383729635559!3d45.7818106160032!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0x8f808af88cda1faa!2sIUT+LYON+1+-+Site+de+Villeurbanne+Doua!5e0!3m2!1sfr!2sfr!4v1425847203418" width="400" height="300" frameborder="0" style="border:0"></iframe>
                <h3 class="subheader text-center t3">Horraire</h3>
                <h5 class="header t3">Déjeuner : de 12h à 15h (tous les jours)</h5>
                <h5 class="header t3">Dîner : de 19h à 20h (tous les jours)</h5>
                <h3 class="subheader text-center t3">Service</h3>
                <h5 class="header t3"> Climatisé , Terrasse, Wifi</h5>
            </div>       
        </div>    
    </div>

    <?php
    include_once 'footer.php';
    ?>

