<?php include "localhost.config"; ?>

<html>
<head>
    <title><?php echo $localhost_title; ?></title>
    <link rel="shortcut icon" href=".favicon.ico">
    <link rel="stylesheet" href="style.css">
    <script src=sorttable.js"></script>
</head>
<div>
    <h1 style="color: #FE4902">INDEX</h1>

    <table>
        <tr>
            <th style="width: 25%">Search : <input id="myInput" onkeyup="myFunction()" placeholder="Search for names.." type="text"></th>
            <th style="width: 20% ; text-align: right;"><a style="color: #FFFFFF"" href="<?php echo $phpmyadmin_PATH;?>">PHP MyAdmin</a></th>

             </tr>


    </table>

    <table id="myTable" class="sortable">
        <thead>

        <tr>
            <th>Filename</th>
            <th>Type</th>
            <th>Size <small>(bytes)</small></th>
            <th>Date Modified</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Opens directory
        $myDirectory=opendir(".");

        // Gets each entry
        while($entryName=readdir($myDirectory)) {
            $dirArray[]=$entryName;
        }

        // Finds extensions of files
        function findexts($filename) {
            $filename=strtolower($filename);
            $exts=explode("[/\\.]", $filename);
            $n=count($exts)-1;
            $exts=$exts[$n];
            return $exts;
        }

        // Closes directory
        closedir($myDirectory);

        // Counts elements in array
        $indexCount=count($dirArray);

        // Sorts files
        sort($dirArray);

        // Loops through the array of files
        for($index=0; $index < $indexCount; $index++) {

            // Gets File Names
            $name=$dirArray[$index];
            $namehref=$dirArray[$index];

            // Gets Extensions
            $extn=findexts($dirArray[$index]);

            // Gets file size
            $size=number_format(filesize($dirArray[$index]));

            // Gets Date Modified Data
            $modtime=date("M j Y g:i A", filemtime($dirArray[$index]));
            $timekey=date("YmdHis", filemtime($dirArray[$index]));

            // Print 'em
            $class ='file';
            print("
      <tr class='$class'>
        <td><a href='./$namehref'>$name</a></td>
        <td><a href='./$namehref'>$extn</a></td>
        <td><a href='./$namehref'>$size</a></td>
        <td sorttable_customkey='$timekey'><a href='./$namehref'>$modtime</a></td>
      </tr>");
        }
        ?>
        </tbody>
</table>
<h2><a href='./?hidden'>Show hidden files</a></h2>
</div>
</body>
<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
</html>