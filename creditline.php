<?php
/*
Plugin Name: Credit line generator
Plugin URI: http://wordpress.org/extend/plugins/credit-line-generator
Description: Adds a credit line for an illustration, linking to the illustration source.
Version: 0.1.3
Author: Branko Collin
Author URI: http://www.brankocollin.nl
*/

/*  Copyright 2009, Branko Collin (email: collin@xs4all.nl)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* 
  Version history:
  
  0.1     Initial product
  0.1.1   Added a couple of Wordpress styles to give it a more unified look.
  0.1.2   Wordpress renamed a couple of action hooks we were using, and uses
          a Tags object now for the Quicktags.
  0.1.3   First Wordpress.org version, cleaned things up a bit, added a readme.txt.
*/ 

/* Todo: 
  - Check if naming differences between me and wp.org cause problems (if so, rename either).
  - Validate the HTML of the form.
  - Use NOSCRIPT where necessary.
  - Make sure the credit line gets inserted at the cursor position 
  (currently it gets appended to the posting).
  - Add features: produce error messages when users insert an 
  invalid URL, or when they fill out two license URLs.
*/

add_action('admin_print_footer_scripts', 'creditline_init');
add_action('admin_head', 'creditline_head');

function creditline_head() {
  echo <<<END
  <style type="text/css">
  <!-- 
  /* Styles for the Credit Line plug-in */
  #creditline {
    background: #fff; 
    border: 2px solid #ccc; 
    padding: 10px; 
    margin: 10px 20%; 
    display: none; 
    position: absolute; 
    top: 20px; 
    left: 20px;
  }
  .creditline_fakebutton {
    display: block; 
    float: left; 
    margin-right: 1em; 
    width: 5em; 
    border: 3px #666 outset; 
    cursor: default; 
    text-align: center;
  }
  .creditline_fakebutton:active {
    border: 3px #666 inset; 
  }
  .creditline_clear { clear: both; }
  .creditline_low { font-size: 1px; line-height: 1px; }
  .creditline_labelcontainer { display: block; width: 128px; float: left; }
  -->
  </style>
END;
} // end creditline_head()

function creditline_init() {
  echo <<<END
  <script type="text/javascript">
    <!--
    QTags.addButton('ed_credit', 'credit', creditlineShowLineBox);
    
    function creditlineShowLineBox() {
      var myObj = document.getElementById('creditline');
      if (myObj !== null) {
        myObj.style.display='block';
      }
    }
    // -->
  </script>
END;
  
  echo <<<END
  <div id="creditline" class="stuffbox">
    <h2>Credit line generator</h2>
    
    <p>Sometimes a body just needs to give credit where it's due (if only because if you do not, gorillas with truncheons come knocking down your door).</p>
    
    <p>The tool below will, if you feed it the right data, come up with something like <code><a href="">Photo</a> by John Smith.</code> or <code><a href="">Photo of gorillas with truncheons knocking down your door</a> by John Smith, <a href="">some rights reserved</a>.</code> and so on.</p>
    
    <p>If you feed this form the wrong data, a puppy will shed a tear somewhere, I am sure.</p>

    <script type="text/javascript">
    <!-- 
      function creditlineErrMessage(num) {
        return '';
      }
      
      function creditlineGetValue(myId) {
        var myObj = document.getElementById(myId);
        if (myObj !== null) {
          if (myObj.value !== undefined) {
            return myObj.value;
          }
          else {
            return '';
          }
        }
        else {
          return '';
        }
      }
      
      function creditlineSubmitLine() {
        var creditlineURL = creditlineGetValue('url');
        var creditlinePhotographer = creditlineGetValue('photographer');
        var creditlineCCURL = creditlineGetValue('ccurl');
        var creditlineFDLURL = creditlineGetValue('fdlurl');
        var creditlineExtension = creditlineGetValue('extension');
        
        var copybuffer = '';
    
        if (creditlineURL != '') {
          prefix = '<a href="' + creditlineURL + '">';
          suffix = '</a>';
        }
        else {
          prefix = '';
          suffix = '';
        }
        
        if (creditlineExtension != '') {
          creditlineExt2 = ' of ' + creditlineExtension.replace(/^[\\t\\n\\r ]*(.+)$/,"$1").replace(/^(.+)[\\t\\n\\r ]*$/,"$1");
        }
        else {
          creditlineExt2 = '';
        }
        
        copybuffer += prefix + 'Photo' + creditlineExt2 + suffix;
        copybuffer += ' by ' + creditlinePhotographer;
    
        if (creditlineCCURL != '') {
          copybuffer += ', <a href="' + creditlineCCURL + '">some rights reserved</a>';
        }
        else { 
          if (creditlineFDLURL != '') {
            copybuffer += '. Used under the terms of <a href="' + creditlineFDLURL;
            copybuffer += '">GNU FDL</a>';
          }
        }
        
        if (copybuffer != '') {
          copybuffer += '.';
          // var myObj = document.getElementById('copyboxcontainer');
          // myObj.style.display = 'block'; 
          // var myObj = document.getElementById('copybox');
          // myObj.value = copybuffer;
        }  
        
        // alert(copybuffer);
        myObj = document.getElementById('content');
        if (myObj !== null) {
          myObj.value += copybuffer;
          creditlineCancelLine();
        }
      }
      
      function creditlineCancelLine() {
        var myObj = document.getElementById('creditline');
        if (myObj !== null) {
          myObj.style.display = 'none';
        }
      }
      // -->
    </script>
      
    <form method="GET" action="#">
      
      <p class="clear">
        <span class="creditline_labelcontainer"><label>URL</label>:</span> 
        <input type="text" name="url" id="url" size="60" /> 
        <br /><small class="howto">Webpage on which you found the photo.</small>
      </p>
      <p class="clear">
        <span class="creditline_labelcontainer"><label>Photographer</label>*:</span> 
        <input type="text" name="photographer" id="photographer" size="40" />
      </p>
      <p class="clear">
        <span class="creditline_labelcontainer"><label>CC license URL</label>:</span> 
        <input type="text" name="ccurl" id="ccurl" size="60" /> 
        <br /><small class="howto">If the photo is Creative Commons licensed.</small>
      </p>
      <p class="clear">
        <span class="creditline_labelcontainer"><label>GNU FDL URL</label>:</span> 
        <input type="text" name="fdlurl" id="fdlurl" size="60" />
        <br /><small class="howto">If the photo is GPL FDL licensed.</small>
      </p>
      <p class="clear">
        <span class="creditline_labelcontainer"><label>&quot;Photo of&quot;</label>:</span> 
        <input type="text" name="extension" id="extension" size="40" /> 
        <br /><small class="howto">The subject of the photo. If you fill out this field with f. ex. "a letterbox", the link text to the photo page will read "Photo of a letterbox." Otherwise, the link will simply read "Photo."</small>
      </p>
      <p class="clear">
        <!-- input type="submit" name="submit" value="Submit" onclick="creditlineSubmitLine(); return false;" />
        <input type="submit" name="cancel" value="Cancel" onclick="creditline_CancelLine(); return false;" / -->
        <span class="button" onclick="creditlineSubmitLine(); return false;">Submit</span>
        <span class="button" onclick="creditlineCancelLine(); return false;">Cancel</span> 
      </p>
      <div class="creditline_clear creditline_low"><!-- --></div>
    </form>
  </div> <!-- #creditline -->
END;
} // end creditline_init()
?>
<?php
// do not add anything after this line
