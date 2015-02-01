<?php
require_once '../core/init.php';

if(session::exists('home')) {
    echo '<p>' . session::flash('home') . '</p>';
}
$user = new user();

if (input::exists()) {
    if(token::check(input::get('token')) === true) {
        $validate = new validation();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'error' => 'the username',
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users',
                'numeric' => false
            ),
            'password' => array(
                'error' => 'the password',
                'required' => true,
                'min' => 6,
            ),
            'password_again' => array(
                'error' => 'the second password',
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'error' => 'the name',
                'required' => true,
                'min' => 2,
                'max' => 50,
            ),
        ));

        if ($validation->passed()) {
            $user = new user();
            $salt = hash::salt(32);
            try {
                $user->create(array(
                    'username' => input::get('username'),
                    'password' => hash::generate(input::get('password'), $salt),
                    'salt' => $salt,
                    'name' => input::get('name'),
                    'joined' => date('Y-m-d H:i:s'),
                    'group' => 1
                ));
                session::flash('home', 'You registered successfully !');
                redirect::to('index.php');

            } catch(Exception $e) {
                die($e->getMessage());
            }
        } else {
            session::flash('register', $validation->errors());
        }
    }
}
require_once 'head.php';
?>
        <article>
        <div class="register-form">
            <div class="errors">
            <?php
            if(session::exists('register')){
                foreach(session::flash('register') as $error){
                    echo $error.'</br>';
                }

            }
            ?>
             <div class="row">
                 <div class = "large-8 column large-centered">
                    <fieldset>
                        <legend>Register</legend>
                        <form action="" method="post" name="registerForm" id="registerForm">
                            <div class="large-12 large-centered column">
                                <label for="username">Username </label>
                                <input type="text" name="username" id="username" value="<?php echo input::get('username'); ?>" autocomplete="off"/>
                            </div> 
                            <div class="large-12 large-centered column">
                                <label for="password">Choose a password </label>
                                <input type="password" name="password" id="password"/>
                            </div>
                            <div class="large-12 large-centered column">
                                <label for="password_again">Enter your password again </label>
                                <input type="password" name="password_again" id="password_again"/>
                            </div>
                            <div class="large-12 large-centered column">
                                <label for="name">Enter your name </label>
                                <input type="text" name="name" id="name" value="<?php echo input::get('name'); ?>"/>
                            </div>
                            <div class="large-6 large-centered column text-center">
                                <input type="hidden" name="token_register" value="<?php echo token::generate(); ?>"/>
                                <button class='button' type='submit' value='register'>Register</button>
                            </div>
                        </form>
                    </fieldset>
                </div>
             </div>
<?php
include_once 'footer.php';
?>

