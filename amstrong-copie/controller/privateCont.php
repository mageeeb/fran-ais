<?php 

$allArticle = getAllArticle($db);
$allCateg = getCategoryMenu($db);

if(isset($_GET['deconnect'])){
    if(deconnect()){
        header("location: ./");
    }       
}

//mofif
if (isset($_POST['submit'])) {
    $postTitle = htmlspecialchars(strip_tags(trim($_POST['name_article'])), ENT_QUOTES);
    $postMin = htmlspecialchars(strip_tags(trim($_POST['min_description_article'])), ENT_QUOTES);
    $postMax = htmlspecialchars(strip_tags(trim($_POST['max_description_article'])), ENT_QUOTES);
    $postSound = htmlspecialchars(strip_tags(trim($_POST['sound_article'])), ENT_QUOTES);
    $postImg1 = htmlspecialchars(strip_tags(trim($_POST['url_image_1'])), ENT_QUOTES);
    $postImg2 = htmlspecialchars(strip_tags(trim($_POST['url_image_2'])), ENT_QUOTES);
    $postImg3 = htmlspecialchars(strip_tags(trim($_POST['url_image_3'])), ENT_QUOTES);
    $idCateg = (isset($_POST['category_id_category']) && is_array($_POST['category_id_category'])) ? $_POST['category_id_category'] : [];

    try {
        postAdminInsert($db, $_SESSION['id_user'], $postTitle, $postMin, $postMax, $postSound,$postImg1,$postImg2,$postImg3, $idCateg);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

if(isset($_GET['p'])){
    if(isset($_GET['article_delete'])&&ctype_digit($_GET['article_delete'])){
        
        $postId = (int) $_GET['article_delete'];
        
        if(postAdminDeleteById($db,$postId)){
            header("Location: ./?m=L'article dont l'id est $postId a été supprimé");
            exit();
        }else{
            header("Location: ./?m=Problème lors de la modification de l'article!");
            exit();
        }
        echo 'delete';
    }
    elseif($_GET['p']==="article_add"){
        
        include_once '../view/privateView/addArticleView.php';
        
    }
    else{
        if(isset($_SESSION) && $_SESSION['permission_user']===0){
    
            include_once '../view/privateView/crudAdmin.php';
        }else{
            $articleByUser = getArticleByUserId($db, $_SESSION['id_user']);
            include_once '../view/privateView/crudUser.php';
        }
    }
    
}

elseif(isset($_GET['article_update']) && ctype_digit($_GET['article_update'])){
    $articleUpdateId = (int) $_GET['article_update']; 
    $imageByArticleId = getImageByarticleId($db, $articleUpdateId);

    if(isset($_POST['name_article_update'])){ 

        $updateTitle = htmlspecialchars(strip_tags(trim($_POST['name_article_update'])),ENT_QUOTES);
        $updateMin = htmlspecialchars(strip_tags(trim($_POST['min_description_article_update'])),ENT_QUOTES);
        $updateMax = htmlspecialchars(strip_tags(trim($_POST['max_description_article_update'])),ENT_QUOTES);
        $updateSound = htmlspecialchars(strip_tags(trim($_POST['sound_article_update'])),ENT_QUOTES);
        $updateWiki = htmlspecialchars(strip_tags(trim($_POST['wiki_article_update'])),ENT_QUOTES);
        $updateImage = $_POST['image_update'];
        $updateImageWikiUrl = $_POST['image_wiki_url'];
        $updateImageWikiName =$_POST['image_wiki_name'];
        $updateCategory = $_POST['id_category'];
        

        $updateArticle = updateArticle($db, $_SESSION['permission_user'], $articleUpdateId, $updateTitle, $updateMin, $updateMax, $updateSound, $updateWiki, $imageByArticleId, $updateImage, $updateImageWikiUrl, $updateImageWikiName, $updateCategory);
        if(is_string($updateArticle)){

            $problem = $updateArticle;
        }
        if($updateArticle===true){
            
            $problem = "L'article a bien été modifié          
            <script>
            setTimeout(\"location.href = './';\", 2000);
            </script>";
        }
    }

    $articleById = getArticleById($db, $articleUpdateId);
    include_once '../view/privateView/updateArticleView.php';
}

else{
    if(isset($_SESSION) && $_SESSION['permission_user']===0){

        include_once '../view/privateView/crudAdmin.php';
    }else{
        $articleByUser = getArticleByUserId($db, $_SESSION['id_user']);
        include_once '../view/privateView/crudUser.php';
    }
   // return true;

}

