<?php
/*
Plugin Name: Credit line generator
Plugin URI: http://wordpress.org/extend/plugins/credit-line-generator
Description: Adds a credit line for an illustration, linking to the illustration source.
Version: 0.1.5
Author: Branko Collin
Author URI: http://www.brankocollin.nl
*/

/*
	Copyright 2009, Branko Collin (email: collin@xs4all.nl)

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
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301					USA
*/

add_action( 'admin_print_footer_scripts', 'creditline_init' );
add_action( 'admin_head', 'creditline_head' );

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
		z-index: 2000;
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
		creditline = {
			showLineBox: function() {
				var myObj  = document.getElementById( 'creditline' );
				if ( myObj !== null ) {
					myObj.style.display='block';
				}
			}
		};

		QTags.addButton( 'ed_credit', 'credit', creditline.showLineBox );
		
		// -->
	</script>
END;

	echo <<<END
	<div id="creditline" class="stuffbox">
		<h2>Credit line generator</h2>
		
		<p><em>Make photo credits easy.</em></p>
		
		<p>The tool below will, if you feed it the right data, come up with something like <code><a href="">Photo</a> by John Smith.</code> or <code><a href="">Photo of kittens</a> by John Smith, <a href="">some rights reserved</a>.</code> and so on.</p>

		<script type="text/javascript">
		<!-- 
      
			creditline.errMessage = function( name ) {
				return '';
			};

			creditline.getValue = function( myId ) {
				var myObj = document.getElementById( myId );
				if ( myObj !== null ) {
					if ( myObj.value !== undefined ) {
						return myObj.value;
					}
					else {
						return '';
					}
				}
				else {
					return '';
				}
			};
				
			creditline.submitLine = function() {
				var creditlineURL          = creditline.getValue( 'url' ),
						creditlinePhotographer = creditline.getValue( 'photographer' ),
						creditlineCCURL        = creditline.getValue( 'ccurl' ),
						creditlineFDLURL       = creditline.getValue( 'fdlurl' ),
						creditlineExtension    = creditline.getValue( 'extension' );
						copyBuffer             = '';

				if ( creditlineURL !== '' ) {
					prefix = '<a href="' + creditlineURL + '">';
					suffix = '</a>';
				}
				else {
					prefix = '';
					suffix = '';
				}
				
				if ( creditlineExtension !== '' ) {
					creditlineExt2 = ' of ' + creditlineExtension.replace( /^[\\t\\n\\r ]*(.+)$/, "$1" ).replace( /^(.+)[\\t\\n\\r ]*$/, "$1" );
				}
				else {
					creditlineExt2 = '';
				}
				
				copyBuffer += prefix + 'Photo' + creditlineExt2 + suffix;
				copyBuffer += ' by ' + creditlinePhotographer;
		
				if ( creditlineCCURL !== '' ) {
					copyBuffer += ', <a href="' + creditlineCCURL + '">some rights reserved</a>';
				}
				else { 
					if ( creditlineFDLURL !== '' ) {
						copyBuffer += '. Used under the terms of <a href="' + creditlineFDLURL;
						copyBuffer += '">GNU FDL</a>';
					}
				}
				
				if ( copyBuffer !== '' ) {
					copyBuffer += '.';
				}
				
				var myObj = document.getElementById( 'content' );
				if ( myObj !== null ) {
					myObj.value += copyBuffer;
					creditline.cancelLine();
				}
			};

			creditline.cancelLine = function() {
				var myObj = document.getElementById( 'creditline' );
				if ( myObj !== null ) {
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
				<span class="button" onclick="creditline.submitLine(); return false;">Submit</span>
				<span class="button" onclick="creditline.cancelLine(); return false;">Cancel</span> 
			</p>
			<div class="creditline_clear creditline_low"><!-- --></div>
		</form>
	</div> <!-- #creditline -->
END;
} // end creditline_init()
?>
<?php
// do not add anything after this line
