<?php
class TreeView
{
    private $root;
 
    public function __construct($path)
    {
        $this->root = $path;
    }
 
    public function getTree()
    {
        return $this->createStructure($this->root, true);
    }
 
    private function createStructure($directory, $root)
    {
        $structure = $root ? '<ul class="treeview">' : '<ul>';
 
        $nodes = $this->getNodes($directory);
        
        foreach ($nodes as $node) {
           
            $path = $directory.'/'.$node;
            if (is_dir($path) ) {
                //var_dump(filemtime($directory.'/'.$node));
                //echo
                $structure .= '<li class="treeview-folder">';
                $structure .= '<span>'.$node.'</span>';
                $structure .= " a été modifié le : " . date ("F d Y H:i:s.", filemtime($directory.'/'.$node));
                $structure .= self::createStructure($path, false);
            } else {
                $taille = filesize($directory.'/'.$node);
                $path = str_replace($this->root.'/', null, $path);
                $structure .= '<li class="treeview-file">';
                $structure .= "<a href='$directory/$node'>".$node."</a> <p>    $taille :octets</p>";
                $structure .= " a été modifié le : " . date ("F d Y H:i:s.", filemtime($directory.'/'.$node));
               
    
            }
            $structure .= '</li>';
        }
            
        return $structure . '</ul>';
        
    }
    
    private function getNodes($directory = null)
    {
        $folders = [];
        $files = [];
    
        
       
        $nodes = scandir($directory);
        foreach ($nodes as $node) {
            if (!$this->exclude($node)) {
                if (is_dir($directory.'/'.$node)) {
                    $folders[] = $node;
                } else {
                    $files[] = $node;
                }
            }
        }
       // var_dump($directory);
        //var_dump($nodes);
        //var_dump($files);
        return array_merge($folders, $files);
    }
 
    private function exclude($filename)
    {
        return in_array($filename, ['.', '..', 'index.php', '.htaccess', '.DS_Store']);
    }
}
 
$treeView = new TreeView('aquaAura');


?>
<!DOCTYPE html>
<html>
<head>
<script   src="https://code.jquery.com/jquery-3.6.0.js"   integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="   crossorigin="anonymous"></script> 
<link rel="stylesheet" href="index.css">
<title>Title of the document</title>
</head>

<body>
<?php echo $treeView->getTree(); ?>
<script src='index.js'></script>
</body>
</html> 