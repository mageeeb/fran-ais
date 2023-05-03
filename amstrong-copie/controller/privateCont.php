<?php 

$allArticle = getAllArticle($db);

if(isset($_GET['deconnect'])){
    if(deconnect()){
        header("location: ./");
    }       
}
if(isset($_GET['p'])){
    if($_GET['p']==="article_id"){
        
    }elseif(isset($_GET['article_delete'])&&ctype_digit($_GET['article_delete'])){

        $postId = (int) $_GET['article_delete'];
    
        if(postAdminDeleteById($db,$postId)){
            header("Location: ./?m=L'article dont l'id est $postId a été supprimé");
            exit();
        }else{
            header("Location: ./?m=Problème lors de la modification de l'article!");
            exit();
        }
        echo 'delete';
    }elseif($_GET['p']==="article_update"){

        echo 'update';
    }elseif($_GET['p']==="article_add"){

        include_once '../view/privateView/addArticleView.php';
    }
    
    else{

        include_once '../view/privateView/crudAdmin.php';  
    }
       
}
else{
    include_once '../view/privateView/crudAdmin.php';
}
//insertion de post
/*if(isset($_GET['createPost'])){

    // si on a envoyé le formulaire
    if(isset($_POST['name_article'],$_POST['min_description_article'], $_POST['max_description_article'],$_POST['sound_article'], $_POST['url_image_1'],$_POST['url_image_2'],$_POST['url_image_3'])){
        $UserId = (int) $_POST['id_user'];
        $postTitle = htmlspecialchars(strip_tags(trim($_POST['name_article'])),ENT_QUOTES);
        $postMinDesc = htmlspecialchars(strip_tags(trim($_POST['min_description_article'])),ENT_QUOTES);
        $postMaxDesc = htmlspecialchars(strip_tags(trim($_POST['max_description_article'])),ENT_QUOTES);
        $postSound = htmlspecialchars(strip_tags(trim($_POST['sound_article'])),ENT_QUOTES);
        $postURL1 = htmlspecialchars(strip_tags(trim($_POST['url_image_1'])),ENT_QUOTES);
        $postURL2 = htmlspecialchars(strip_tags(trim($_POST['url_image_2'])),ENT_QUOTES);
        $postURL3 = htmlspecialchars(strip_tags(trim($_POST['url_image_3'])),ENT_QUOTES);
        $idCateg = (isset($_POST['category_id'])&&is_array($_POST['category_id']))? $_POST['category_id'] : [];

        // EXERCICE Pouvoir insérer un article AVEC ses catégories
        postAdminInsert($connectPDO,$UserId,$postTitle,$postContent,$idCateg);
    }

    // Appel des catégories pour le multi-choix dans le formulaire
    $categoryChoice = getAllCategoryMenu($connectPDO);

    // Appel des utilisateurs
    $userChoice = getAllUsers($connectPDO);

    // appel de la vue pour insertion
    include "../view/privateView/privateInsertView.php";

// on veut supprimer un post    
}*/

if(isset($_GET['article_add'])){

    // si on a envoyé le formulaire d'insertion
    if(isset($_POST['name_article'],$_POST['min_description_article'],$_POST['max_description_article'],$_POST['sound_article'],)){
        $UserId = (int) $_POST['id_article']; // si erreur => 0
        $postTitle = htmlspecialchars(strip_tags(trim($_POST['name_article'])),ENT_QUOTES);
        $postMin = htmlspecialchars(strip_tags(trim($_POST['min_description_article'])),ENT_QUOTES);
        $postMax = htmlspecialchars(strip_tags(trim($_POST['max_description_article'])),ENT_QUOTES);
        $postSound = htmlspecialchars(strip_tags(trim($_POST['sound_article'])),ENT_QUOTES);
        // ternaire ! si tableau les valeurs et clefs ne sont pas protégée contre une manipulation externe (injection etc...)
        $idCateg = (isset($_POST['category_id_category'])&&is_array($_POST['category_id_category']))? $_POST['category_id_category'] : [];

    if(!empty($UserId)&&!empty($postTitle)&&!empty($postMin)&&!empty($postMax)&&!empty($postSound)) {
        //  Pouvoir insérer un article AVEC ses catégories
        $insert = postAdminInsert($db, $UserId, $postTitle, $postMin,$postSound,$postMax);
        if($insert===true){
            $message = "Article inséré dans la DB";
        }
    }
    }

    // Appel des catégories pour le multi-choix dans le formulaire
    $categoryChoice = getAllCategoryMenu($db);

    // Appel des utilisateurs
    $userChoice = getAllUsers($db);

    // appel de la vue pour insertion
    include "../view/privateView/addArticleView.php";

}


