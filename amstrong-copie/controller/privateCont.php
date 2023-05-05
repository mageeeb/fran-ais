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
/*if(isset($_GET['article_add'])){

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
        postAdminInsert($db,$UserId,$postTitle,$postMinDesc,$postSound,$postMaxDesc);
    }

    // Appel des catégories pour le multi-choix dans le formulaire
    $categoryChoice = getCategoryMenu($db);

    // Appel des utilisateurs
    $userChoice = getAllArticle($db);
    //$result = $requete->execute();

    // appel de la vue pour insertion
    include "../view/privateView/privateInsertView.php";

// on veut supprimer un post    
}

if(isset($_GET['article_add'])){

    // si on a envoyé le formulaire d'insertion
    if(isset($_POST['name_article'],$_POST['min_description_article'],$_POST['max_description_article'],$_POST['sound_article'])) {
        $postTitle = htmlspecialchars(strip_tags(trim($_POST['name_article'])),ENT_QUOTES);
        $postMin = htmlspecialchars(strip_tags(trim($_POST['min_description_article'])),ENT_QUOTES);
        $postMax = htmlspecialchars(strip_tags(trim($_POST['max_description_article'])),ENT_QUOTES);
        $postSound = htmlspecialchars(strip_tags(trim($_POST['sound_article'])),ENT_QUOTES);
        $idCateg = (isset($_POST['category_id_category']) && is_array($_POST['category_id_category'])) ? $_POST['category_id_category'] : [];

        if(!empty($postTitle) && !empty($postMin) && !empty($postMax) && !empty($postSound)) {
            //  Pouvoir insérer un article AVEC ses catégories
            $insert = postAdminInsert($db, $postTitle, $postMin, $postSound, $postMax, $idCateg);
            if($insert === true) {
                $message = "Article inséré dans la DB";
            }
        }
    }

    // Appel des catégories pour le multi-choix dans le formulaire
    $categoryChoice = getCategoryMenu($db);

    // appel de la vue pour insertion
    include "../view/privateView/addArticleView.php";
}*/
//var_dump($$requete);
if (isset($_POST['submit'])) {
    $postTitle = htmlspecialchars(strip_tags(trim($_POST['name_article'])),ENT_QUOTES);
    $postMin = htmlspecialchars(strip_tags(trim($_POST['min_description_article'])),ENT_QUOTES);
    $postMax = htmlspecialchars(strip_tags(trim($_POST['max_description_article'])),ENT_QUOTES);
    $postSound = htmlspecialchars(strip_tags(trim($_POST['sound_article'])),ENT_QUOTES);
    $idCateg = (isset($_POST['category_id_category']) && is_array($_POST['category_id_category'])) ? $_POST['category_id_category'] : [];

    if(!empty($postTitle) && !empty($postMin) && !empty($postMax) && !empty($postSound)) {
        $requete = $db->prepare('INSERT INTO article (name_article, min_description_article, max_description_article, sound_article) VALUES (:name_article, :min_description_article, :max_description_article, :sound_article)');
        $requete->bindValue(":name_article", $postTitle, PDO::PARAM_STR);
        $requete->bindValue(":min_description_article", $postMin, PDO::PARAM_STR);
        $requete->bindValue(":max_description_article", $postMax, PDO::PARAM_STR);
        $requete->bindValue(":sound_article", $postSound, PDO::PARAM_STR);

        $result = $requete->execute();

        if(!$result) {
            echo "un problème est survenu!";
        } else {
            echo "c'est inséré";
       
        }}}




