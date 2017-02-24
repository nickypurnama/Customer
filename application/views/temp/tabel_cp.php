<?php
    $msg=$this->session->flashdata('msg');
    echo $msg;
?>
<table class="table table-bordered table-striped">
<thead>
<tr>
  <th>Title</th>
  <th>First Name</th>
  <th>Name</th>
  <th>Gender</th>
  <th>Telepon/Ext</th>
  <th>Mobile Phone</th>
  <th>Fax</th>
  <th>Email</th>
  <th>Date of Birth</th>
  <th>Call Frequency</th>
  <th>Date Reg.</th>
  <th>Dept.</th>
  <th>Func.</th>
  <th>Del</th>
</tr>
</thead>
    <tbody>
    <?php
        if(isset($row)){
            $no=1;
            foreach($row as $a){
                if($a['GENDER'] == "1"){
                    $gg="Male";
                }elseif($a['GENDER'] == "2"){
                    $gg="Female";
                }else{
                    $gg="";
                }
                echo "
                <tr>
                    <td>".$a['TITLE_CP']."</td>
                    <td>".$a['FIRSTNAME_CP']."</td>
                    <td>".$a['NAME_CP']."</td>
                     <td>".$gg."</td>
                    <td>".$a['TLP_CP']."/".$a['EXT_CP']."</td>
                    <td>".$a['HP_CP']."</td>
                    <td>".$a['FAX_CP']."</td>
                    <td>".$a['EMAIL_CP']."</td>
                    <td>".$a['TGL_LAHIR']."</td>
                    <td>".$a['CALL_REQ']."</td>
                     <td>".$a['DATE_REGISTER']."</td>
                    <td>".$a['DEPARTMENT']."</td>
                    <td>".$a['FUNC']."</td>
                    <td style='text-align:center'><a href='javascript:hapusTemp(\"".$a['ID_CP_TEMP']."\");'><i class='icon-remove'></i></a></td>
                </tr>
                ";
                $no++;
            }
        }
    ?>
    </tbody>
</table>
