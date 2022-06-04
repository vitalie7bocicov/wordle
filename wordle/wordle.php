<?php
        session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
    <title>Wordle</title>
</head>
<body>
   
        <h1>
            <a href="">Wordle
            </a>
        </h1>
   
    
    <div class="game">
        <div class="container">
        <?php
            
            if(isset($_GET['word'])){
                if( strlen($_GET['word'])>5 || strlen($_GET['word'])==0){
                    //stop
                }
                else
                    if(!isset($_SESSION['game_over']))//if word is ok and game is not over
                    {
                        $word=$_GET['word'];
                        if (empty($_SESSION['words'])) {//if this is the first word
                            $words=array($word);
                        }
                        else
                        {
                            $words = $_SESSION['words'];  
                            array_push($words, $word);
                        }  
                        $_SESSION['words']=$words; //add word to words array
                }
                $words = $_SESSION['words'];
                $correctWord="brave"; 
                if(isset($_SESSION['game_over']) || count($words)==6 || strcmp($word,$correctWord)==0)//if this is the last word or the word is correct
                {
                    $_SESSION['game_over']=1;  
                }

                foreach ($words as $word) 
                {
                    $copyWord=$correctWord;
                    $letters = str_split($word);
                    foreach ($letters as $letter) {
                        if(strstr($copyWord, $letter))//if the letter is in the correct word
                        {
                            if(strpos($copyWord,$letter)==strpos($word,$letter))//if the letter is in the correct position
                            {
                                echo "<div class=\"letter green\"> $letter </div>";
                               
                               $word[strpos($word,$letter)]="_";
                               $copyWord[strpos($copyWord,$letter)]="_"; //remove the good leter from the word and the correct word because it can't be used again
                            }
                            else {//if the letter is in the correct word but the position is bad

                                $wordX=$word;
                                $correctX=$copyWord;
                                //check if the letter can be positioned  in the correct position in the following steps
                                while(strpos($wordX,$letter)<>strpos($correctX,$letter)){
                                    $wordX=substr( $wordX, 1 );
                                    $correctX=substr($correctX, 1 );
                                    if(empty($wordX)){
                                            break;
                                    }
                                }

                                if(strpos($wordX,$letter)===strpos($correctX,$letter)){//if found a better position for the letter mark it as red
                                    $word[strpos($word,$letter)]="_";
                                    echo "<div class=\"letter red\"> $letter </div>";
                                }
                               else
                                if(empty($wordX) || !strpos($correctX,$letter)){//if no better position was found, mark it as yellow
                                    $word[strpos($word,$letter)]="_";
                                    $copyWord[strpos($copyWord,$letter)]="_";
                                    echo "<div class=\"letter yellow\"> $letter </div>";
                                }
                            }
                            
                        }
                        else //if letter is not in the correct word mark it as red
                        {
                            echo "<div class=\"letter red\"> $letter </div>";
                        }
                    }
                }
            }
            else{//reset game
                unset($_SESSION['words']);
                unset($_SESSION['game_over']);
            }
            
        ?>
    </div>
    <form action="" >
        <label for="word">Type your word:</label>
         <input type="text" id="word" name="word" required minlength="5" maxlength="5" autofocus 
         <?php
             if(isset($_SESSION['game_over'])){
                    echo "disabled";
                }
         ?>
         >

        <input type="submit" value="Submit" 
        <?php
             if(isset($_SESSION['game_over'])){
                    echo "disabled";
                }
         ?>>
    </form>
    </div>
    
</body>
</html>




