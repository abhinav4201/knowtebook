<?php
    require_once 'functions.php';
    if (isset($_POST['category']))
    {
        $cat = sanitizeString($_POST['category']);
        if($cat=="all")
        {
            $result= queryMysql("SELECT * FROM `requirement` ORDER BY `issue no` DESC");
            if($result->num_rows)
            {
                $rows=$result->num_rows;
                for ($j = 0 ; $j < $rows ; ++$j)
                {
                    $row=$result->fetch_array(MYSQLI_ASSOC);
                    $it= $row['issue no'];
                    $usr=$row['username'];
                    echo '<div class="in500" aria-label="issue no"><b>Issue No.'. $row['issue no'].'</b>'.'&nbsp;&nbsp;&#8652;&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$row['username'].'</a>&nbsp;&nbsp;&#9872;&nbsp;&nbsp;'.'<span class="available">'.$row['posting time'].'</span></div>';
                    echo '<div class="it500" aria-label="title"><a href="yourrequirecmnt.php?content='.$it.'">'. $row['issue'].'</a></div>';
                    echo '<div class="des500" aria-label="description">Description: &nbsp;'.$row['description'].'</div>';                            
                }
            }
        }
        else
        {
            $result= queryMysql("SELECT * FROM `requirement` WHERE `category`='$cat' ORDER BY `issue no` DESC");
            if($result->num_rows)
            {
                $rows=$result->num_rows;
                for ($j = 0 ; $j < $rows ; ++$j)
                {
                    $row=$result->fetch_array(MYSQLI_ASSOC);
                    $it= $row['issue no'];
                    $usr=$row['username'];
                    echo '<div class="in500" aria-label="issue no"><b>Issue No.'. $row['issue no'].'</b>'.'&nbsp;&nbsp;&#8652;&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$row['username'].'</a>&nbsp;&nbsp;&#9872;&nbsp;&nbsp;'.'<span class="available">'.$row['posting time'].'</span></div>';
                    echo '<div class="it500" aria-label="title"><a href="yourrequirecmnt.php?content='.$it.'">'. $row['issue'].'</a></div>';
                    echo '<div class="des500" aria-label="description">Description: &nbsp;'.$row['description'].'</div>';                            
                }
            }
        }
    }
    if(isset($_POST['adcategory']))
    {
        $ad=sanitizeString($_POST['adcategory']);
        if($ad=="Select Category")
        {
            echo 'Please Select Category';
        }
    }
    $connection->close();
?>