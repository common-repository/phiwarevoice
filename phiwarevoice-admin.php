<?php
/*  Copyright 2011  Daniele Madama  (d.madama@gmail.com)

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

function phiwarevoice_adminMenu() {
    add_options_page('PhiwareVoice Options', 'PhiwareVoice', 'administrator', 'phiwarevoice', 'phiwarevoice_settings');
}

function phiwarevoice_settings() {
    // Read their posted value
    $opt_val = $_POST["customername"];

    // See if the user has posted us some information
    if ($opt_val != '') {
        $showonlyindetail = $_POST["showonlyindetail"];
        $readblogtitle = $_POST["readblogtitle"];
        $buttontype = $_POST["buttontype"];
        $buttonsize = $_POST["buttonsize"];
        
        // Save the posted value in the database
        update_option(PHIWAREVOICE_OPTION_CUSTOMERNAME, $opt_val);
        update_option(PHIWAREVOICE_OPTION_SHOWONLYINDETAIL, $showonlyindetail);
        update_option(PHIWAREVOICE_OPTION_READBLOGTITLE, $readblogtitle);
        update_option(PHIWAREVOICE_OPTION_BUTTONTYPE, $buttontype);
        update_option(PHIWAREVOICE_OPTION_BUTTONSIZE, $buttonsize);
        // Put an options updated message on the screen
?>
  <div class="updated"><p><strong>Options Saved</strong></p></div>
<?php
    }
?>
  <div class="wrap">
    <br />
    <div align="center">
      <a href="http://voice.phiware.com" target="_blank">
        <img src="http://voice.phiware.com/sites/voice.phiware.ch/files/logo.png" />
      </a>
    </div>
    <div id="icon-options-general" class="icon32"><br /></div> 
    <h2>PhiwareVoice Settings</h2>
    <form action="" method="post" name="voxsettings">
      <table class="form-table">
        <tr valign="top">
          <th scope="row">
            <label for="customername">Customer Name</label>
          </th>
          <td>
            <input name="customername" type="text" id="customername" value="<?php echo phiwarevoice_getCustomerName(); ?>" class="regular-text" />
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            <label for="showonlyindetail">Show the button only in single post/page?</label>
          </th>
          <td>
            <input name="showonlyindetail" type="checkbox" id="showonlyindetail" value="true" <?php if (phiwarevoice_getShowOnlyInDetail()) echo 'checked="checked"'; ?> />
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            <label for="readblogtitle">Do you want to read the blog title too?</label>
          </th>
          <td>
            <input name="readblogtitle" type="checkbox" id="readblogtitle" value="true" <?php if (phiwarevoice_getReadBlogTitle()) echo 'checked="checked"'; ?> />
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            <label for="buttontype">Type of the button</label>
          </th>
          <td>
            <select name="buttontype" id="buttontype">
              <option value="<?php echo PHIWAREVOICE_TYPE_LINK; ?>" <?php if (phiwarevoice_getButtonType() == PHIWAREVOICE_TYPE_LINK) echo 'selected'; ?>>Link</option>
              <option value="<?php echo PHIWAREVOICE_TYPE_FORM; ?>" <?php if (phiwarevoice_getButtonType() == PHIWAREVOICE_TYPE_FORM) echo 'selected'; ?>>Form</option>
            </select>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            <label for="buttonsize">Button size</label>
          </th>
          <td>
            <input id="buttonsize-70" type="radio" value="button_70.png" name="buttonsize" <?php if (phiwarevoice_getButtonSize() == 'button_70.png') echo 'checked'; ?>> <img title="Phiware Voice" alt="listen this page" src="http://voice.phiware.com/resources/buttons/button_70.png">
            <br/>
            <input id="buttonsize-80" type="radio" value="button_80.png" name="buttonsize" <?php if (phiwarevoice_getButtonSize() == 'button_80.png') echo 'checked'; ?>> <img title="Phiware Voice" alt="listen this page" src="http://voice.phiware.com/resources/buttons/button_80.png">
            <br/>
            <input id="buttonsize-90" type="radio" value="button_90.png" name="buttonsize" <?php if (phiwarevoice_getButtonSize() == 'button_90.png') echo 'checked'; ?>> <img title="Phiware Voice" alt="listen this page" src="http://voice.phiware.com/resources/buttons/button_90.png">
            <br/>
            <input id="buttonsize-113" type="radio" value="button_113.png" name="buttonsize" <?php if (phiwarevoice_getButtonSize() == 'button_113.png') echo 'checked'; ?>> <img title="Phiware Voice" alt="listen this page" src="http://voice.phiware.com/resources/buttons/button_113.png">
          </td>
        </tr>
      </table>

      <p class="submit">
        <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
      </p>
    </form>
  </div>
<?php
}

?>
