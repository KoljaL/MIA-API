<?php

// TODO
//
// PHP DOCS
//

// startfolder (relative)
$startfolder = '../';
// name of Docfile
$docfile = './../API-Docs.md';

// files and folders to exclude from scraping
$exclude = array('makeDocs.php', 'config.php','./vendor','adminer');

// file extensions to scrape
$extensions = array('php','html');


run($startfolder, $docfile, $exclude, $extensions);



//
// SVELTE DOCS
//

// startfolder (relative)
$startfolder = '../../svelte';
// name of Docfile
$docfile = './../../svelte/Svelte-Docs.md';

// files and folders to exclude from scraping
$exclude = array('dist', 'node_modules','public');

// file extensions to scrape
$extensions = array('js','svelte','html');


// run($startfolder, $docfile, $exclude, $extensions);


function run($startfolder, $docfile, $exclude, $extensions)
{
    // scan for php files
    $files = [];
    $o_dir = new RecursiveDirectoryIterator($startfolder);
    $o_iter = new RecursiveIteratorIterator($o_dir);
    foreach ($o_iter as $o_info) {
        $pathname = $o_info->getPathname();
        $extension = $o_info->getExtension();
        if (strposa($extension, $extensions) && !strposa($pathname, $exclude)) {
            $files[] = $o_info->getPathname();
        }
    }
    // pprint($files, 'files');


    // make name for title
    $name = explode('/', $docfile);
    $name = $name[array_key_last($name)];
    $name = explode('.', $name)[0];
    $markdown = '# '.$name.PHP_EOL;

    // loop over all $files
    foreach ($files as $file) {
        // get php file
        $fileContent = file_get_contents($file);

        // add space to fileContent for regex, but why?
        $fileContent = ' '.$fileContent;

        // array for docStrings
        $phpDoc = [];

        // remove '<style>...</style>' from file content, because multiline comments in CSS are the same way like docstrings
        $fileContent = preg_replace('/<\s*style.+?<\s*\/\s*style>/si', '', $fileContent);

        // find every comment in current file
        preg_match_all("/\s(?:\/\*(?:[^*]|(?:\*[^\/]))*\*\/)\s/", $fileContent, $phpDoc, PREG_PATTERN_ORDER);


        // render only if there are phpDocs
        if (!empty($phpDoc[0])) {
            // pprint($phpDoc[0], $file);

            $filename = str_replace('../', '', $file);
            $filename = str_replace('svelte/', '', $filename);

            $markdown .= " ".PHP_EOL;
            $markdown .= " ".PHP_EOL;
            $markdown .= "## ".$filename.PHP_EOL;

            // parse every comment in this file
            foreach ($phpDoc[0] as $k => $v) {
                // remove comment characters
                $comment = str_replace('/**', '', $v);
                $comment = str_replace('*/', '', $comment);
                $comment = str_replace('*', '', $comment);

                // remove empty lines
                $comment = preg_replace('/^\h*\v+/m', '', $comment);

                // split each comment by lines
                $comment = explode(PHP_EOL, $comment);

                $fail = false;
                // parse every line
                foreach ($comment as $line) {
                    // remove empty lines again..
                    if (''!==$line) {
                        // remove whitespaces
                        $line = trim($line);

                        // add markdown
                        if (substr($line, 0, 6) === "@param") {
                            $line = str_replace('@param', '**param**', $line);
                            $line =  preg_replace('/ /', ' ` ', $line, 2);
                        }

                        if (substr($line, 0, 7) === "@return") {
                            $line =  str_replace('@return', '**return**', $line);
                            $line =  preg_replace('/ /', ' ` ', $line, 2);
                        }

                        // headline by finding 'title' on line beginning
                        if (substr($line, 0, 5) === "title") {
                            $line =  str_replace('title', '### ', $line);
                        }

                        // headline by finding ')' as last character
                        $line = (substr($line, -1) === ")") ? PHP_EOL.'### `'.$line.'`' : $line;

                        // collect all lines
                        $markdown .= $line.'  '.PHP_EOL;
                    }
                }
            }
        }
    }
    // pprint($markdown, 'markdown');

    // write to file
    file_put_contents($docfile, $markdown);



    // nice output
    $markdown = str_replace('`', '\`', $markdown);
    echo /*HTML*/<<<HTML
<script src="https://cdnjs.cloudflare.com/ajax/libs/markdown-it/13.0.1/markdown-it.min.js" integrity="sha512-SYfDUYPg5xspsG6OOpXU366G8SZsdHOhqk/icdrYJ2E/WKZxPxze7d2HD3AyXpT7U22PZ5y74xRpqZ6A2bJ+kQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
var md = window.markdownit();
var result = md.render(`{$markdown}`);
console.log(result)
</script>
<style>
  body{
    margin:0;
  }
body{
  width:100%;
  height:100%;
  padding:1em;
  color: #adbac7;
  background: rgb(34, 39, 46);
}
code{
  background: rgba(99, 110, 123, 0.4);
  border-radius: 3px;
  padding:2px;
}
</style>
<main id=main></main>
<script>
document.getElementById('main').innerHTML = result;
</script>
HTML;
}

/**
 *
 * FUNCTIONS
 *
 */


/**
 *
 * The function takes two arguments, the first is the data to be printed, the second is an optional
 * name for the data
 *
 * @param data The data to be printed.
 * @param name The name of the variable you're printing.
 */
function pprint($data, $name = '')
{
    print '<div style="width:max-content; background:#ccc;padding-inline:.25em;margin:.5em;">';
    print '<h4 style=background:#aaa;>'.$name.'</h4> ';
    print "<pre>";
    print_r($data);
    // var_export($data);
    print "</pre>";
    print "</div>";
}


/**
 * It returns true if any of the needles are found in the haystack
 *
 * @param string haystack The string to search in
 * @param array needles An array of strings to search for.
 * @param int offset The optional offset parameter allows you to specify which character in haystack to
 * start searching.
 *
 * @return bool a boolean value.
 */

function strposa(string $haystack, array $needles): bool
{
    foreach ($needles as $needle) {
        if (strpos($haystack, $needle) !== false) {
            return true; // stop on first true result
        }
    }

    return false;
}