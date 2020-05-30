<?php
include("../php-config.conf");
include("../php-db-config.conf");
$br = $_GET['br'];
?>        
<script type="text/javascript" src="index_pos.js?180120"></script>
<?php
$sql = "SELECT * FROM shop_setting WHERE BranchID='$br'";
$result = $conn_db->query($sql);
while ($db = $result->fetch_array()) {
$Set_System_View = $db['System_View'];
$Set_VAT = $db['VAT'];
$Set_Service_Charge = $db['Service_Charge'];
$Set_Brief_Report = $db['Brief_Report'];
$Set_Screen2 = $db['Screen2'];

$Invoice_Title = $db['Invoice_Title'];
$Address_Title = $db['Address_Title'];
$TAXID = $db['TAXID'];
$POSID = $db['POSID'];
$Queue = $db['Queue'];
$Member_Name = $db['Member_Name'];
$Member_Point = $db['Member_Point'];
$Footer = $db['Footer'];
$Footer_Option = $db['Footer_Option'];
$Lang_POS = $db['Lang_POS'];
$Lang_Bill = $db['Lang_Bill'];
$Currency = $db['Currency'];
$Payment_Option = $db['Payment_Option'];
$LandingIP = $db['LandingIP'];
$Ticket = $db['Ticket'];
$Set_Scan_Member = $db['Scan_Member'];

$Delivery_Min_Item = $db['Delivery_Min_Item'];
$Delivery_Min_Baht = $db['Delivery_Min_Baht'];

$Member_Register_Point = $db['Member_Register_Point'];
}
?>
<!-- Shop Setting-->
<div class="setting-box">
    <h2 class="setting-title">Shop Settings</h2>
    <table class="permission-table" cellspacing="1" style="background-color:#ccc;">
        <tr>
            <td style="background-color:#ddd;width:120px;text-align:left" valign="top">
                VAT charge 
            </td>
            <td style="background-color:#ddd;text-align:left" valign="top">
                <div style="width:50px;float:left;"><input type="number" id="Set_VAT" value="<?= $Set_VAT ?>" style="text-align:right"></div> 
                <div style="float:left;padding-top:15px;"> %</div>
            </td>
        </tr>
        <tr>
            <td style="background-color:#ddd;text-align:left" valign="top">
                Currency
            </td>
            <td style="background-color:#ddd;text-align:left" valign="top">
                <div style="width:300px;float:left;">
                    <select id="Currency">
                        <option value="TH" <?php
                        if ($Currency == 'TH') {
                        echo "selected='selected'";
                        }
                        ?>>Thai</option>
                        <option value="LO" <?php
                        if ($Currency == 'LO') {
                        echo "selected='selected'";
                        }
                        ?>>Laos</option>
                    </select>
                </div> 
            </td>
        </tr>

        <tr>
            <td style="background-color:#ddd;text-align:left;" valign="top" class="Set_POS">
                Brief Report<br><span style="font-size:12px">(POS Page)</span>
            </td>
            <td style="background-color:#ddd;text-align:left;" valign="top" class="Set_POS">
                <select id="Set_Scan_Member" name="flip-select" data-role="flipswitch" style="width:150px;">
                    <option value="0">Off</option>
                    <option value="1"<?php
                    if ($Set_Scan_Member == 1) {
                    echo "selected='selected'";
                    }
                    ?>>On</option>
                </select>
            </td>
        </tr>

        <tr>
            <td style="background-color:#ddd;text-align:left;" valign="top" class="Set_POS">
                Scan Member Code<br><span style="font-size:12px">(POS Page)</span>
            </td>
            <td style="background-color:#ddd;text-align:left;" valign="top" class="Set_POS">
                <select id="Set_Brief_Report" name="flip-select" data-role="flipswitch" style="width:150px;">
                    <option value="0">Off</option>
                    <option value="1"<?php
                    if ($Set_Brief_Report == 1) {
                    echo "selected='selected'";
                    }
                    ?>>On</option>
                </select>
            </td>
        </tr>
        <tr>
            <td style="background-color:#ddd;width:100px;text-align:left;display:none;" valign="top" class="Set_Screen2">
                2nd Screen
            </td>
            <td style="background-color:#ddd;text-align:left;display:none;" valign="top" class="Set_Screen2">
                <select id="Set_Screen2" name="flip-select" data-role="flipswitch" style="width:150px;">
                    <option value="0">Off</option>
                    <option value="1"<?php
                    if ($Set_Screen2 == 1) {
                    echo "selected='selected'";
                    }
                    ?>>On</option>
                </select>
            </td>
        </tr>
    </table>
    <br/><button class="ui-btn ui-btn-icon-left ui-icon-save ui-btn-corner-all ui-btn-inline ui-btn-b" onclick="save_settings();">Save Settings</button>
</div>



<!-- Payment Option-->
<?php
$Payment_Option_Split = explode(",", $Payment_Option);
    for ($opt = 0;$opt <= COUNT($Payment_Option_Split);$opt++) {
        $This_Opt = $Payment_Option_Split[$opt];
        $a = "Payment$This_Opt";
        $$a = 1;
    }
?>
<div class = "setting-box">
    <h2 class = "setting-title">Payment Option</h2>
    <table class = "permission-table" cellspacing = "1" style = "background-color:#ccc;">
        <tr>
            <td style = "background-color:#ddd;text-align:left" valign = "top">
                <div class = "option-section">
                    <label>
                        <div class = "option-node"><img src = "../../img/bank_note/9.png"></div>
                        <div class = "option-active"><input type = "checkbox" class = "Payment-Option" id = "Payment-9" <?php
                            $b = "Payment9";
                            if ($$b) {
                            echo "checked='checked'";
                            }
                            ?>  data-role="flipswitch"data-mini="true"></div>
                    </label>
                </div>
            </td>
        </tr>        
        <tr>
            <td style="background-color:#ddd;text-align:left" valign="top">
                <?php
                for ($op = 201; $op <= 205; $op++) {
                ?>
                <div class="option-section">
                    <label>
                        <div class="option-node"><img src="../../img/bank_note/<?= $op ?>.png"></div>
                        <div class="option-active"><input type="checkbox" class="Payment-Option"  id="Payment-<?= $op ?>" <?php
                            $b = "Payment$op";
                            if ($$b) {
                            echo "checked='checked'";
                            }
                            ?>  data-role="flipswitch"data-mini="true"></div>
                    </label>
                </div>
                <?php } ?>
            </td>
        </tr>        
        <tr>
            <td style="background-color:#ddd;text-align:left" valign="top">
                <?php
                for ($op = 301; $op <= 307; $op++) {
                    ?>
                    <div class="option-section">
                        <label>
                            <div class="option-node"><img src="../../img/bank_note/<?= $op ?>.png"></div>
                            <div class="option-active"><input type="checkbox" class="Payment-Option"  id="Payment-<?= $op ?>" <?php
                                $b = "Payment$op";
                                if ($$b) {
                                    echo "checked='checked'";
                                }
                                ?>  data-role="flipswitch"data-mini="true"></div>
                        </label>
                    </div>
                <?php } ?>
            </td>
        </tr>
    </table>
    <br/>
    <button class="ui-btn ui-btn-icon-left ui-icon-save ui-btn-corner-all ui-btn-inline ui-btn-b" onclick="save_settings();">Save Settings</button>
    <style type="text/css">
        .option-section{
            padding:5px;
            float:left;
            width:120px;
            background-color:white;
            margin:3px;
            border-radius:2px;
        }
        .option-node img{
            min-width:100%;
        }
        .option-active{
            text-align:center;
        }
    </style>
</div>


<div class="setting-box">
    <h2 class="setting-title">Name&Languages</h2>
    <table class="permission-table" cellspacing="1" style="background-color:#ccc;">
        <tr>
            <td style="background-color:#ddd;width:100px;text-align:left" valign="top">POS Screen</td>
            <td style="background-color:#ddd;text-align:left" valign="top">
                <div style="width:300px;float:left;"><select id="Lang_POS">
                        <option value="1" <?php
                        if ($Lang_POS == 1) {
                            echo "selected='selected'";
                        }
                        ?>>Language1</option>
                        <option value="2" <?php
                        if ($Lang_POS == 2) {
                            echo "selected='selected'";
                        }
                        ?>>Language2</option>
                        <option value="3" <?php
                        if ($Lang_POS == 3) {
                            echo "selected='selected'";
                        }
                        ?>>Language3</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td style="background-color:#ddd;text-align:left" valign="top">Invoice/Bill</td>
            <td style="background-color:#ddd;text-align:left" valign="top">
                <div style="width:300px;float:left;"> <select id="Lang_Bill">
                        <option value="1" <?php
                        if ($Lang_Bill == 1) {
                            echo "selected='selected'";
                        }
                        ?>>Language1</option>
                        <option value="2" <?php
                        if ($Lang_Bill == 2) {
                            echo "selected='selected'";
                        }
                        ?>>Language2</option>
                        <option value="3" <?php
                        if ($Lang_Bill == 3) {
                            echo "selected='selected'";
                        }
                        ?>>Language3</option>
                    </select>
                </div>
            </td>
        </tr>
    </table>
    <br/><button class="ui-btn ui-btn-icon-left ui-icon-save ui-btn-corner-all ui-btn-inline ui-btn-b" onclick="save_settings();">Save Settings</button>
</div>


<div class="setting-box">
    <h2  class="setting-title">Billing Ticket<input type="hidden" id="Billing_Ticket" value="<?= $Ticket ?>"></h2>
    <table class="main-table" style="width:100%;table-layout: fixed; ">
        <tr>
            <td style="width:100px;text-align:center;font-weight:bold" class="billing_ticket" id="billing_ticket0" valign="top" onclick="change_ticket(0)">No Ticket</td>
            <td style="text-align:center;font-weight:bold" class="billing_ticket" id="billing_ticket1" onclick="change_ticket(1)">by Order<br/><img src="../../img/settings/ticket_1.svg" style="width:100%"></td>
            <td style="text-align:center;font-weight:bold" class="billing_ticket" id="billing_ticket2" onclick="change_ticket(2)">by Product<br/><img src="../../img/settings/ticket_2.svg?1000" style="width:100%"></td>
            <td style="text-align:center;font-weight:bold" class="billing_ticket" id="billing_ticket3" onclick="change_ticket(3)">by Kitchen<br/><img src="../../img/settings/ticket_3.svg" style="width:100%"></td>
        </tr>
        <tr>
            <td colspan='3'><button class="ui-btn ui-btn-icon-left ui-icon-save ui-btn-corner-all ui-btn-inline ui-btn-b" onclick="save_settings();">Save Settings</button></td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    $("#billing_ticket<?= $Ticket ?>").css("background-color", "yellow");
    function change_ticket(ticket) {
        $("#Billing_Ticket").val(ticket);
        $(".billing_ticket").css("background-color", "transparent");
        $("#billing_ticket" + ticket).css("background-color", "yellow");
    }
</script>


<div class="setting-box">
    <h2  class="setting-title">Membership</h2>
    <table class="main-table">
        <tr>
            <th>Point on Register</th>
            <td><input type="number" id="Member_Register_Point" value="<?= $Member_Register_Point ?>" style="width:100px;"></td>
        </tr>
        <tr>
            <td colspan='2'><button class="ui-btn ui-btn-icon-left ui-icon-save ui-btn-corner-all ui-btn-inline ui-btn-b" onclick="save_settings();">Save Settings</button></td>
        </tr>
    </table>
</div>
<div  class="setting-box">
    <h2 class="setting-title">Slip Management</h2>
    <div style="text-align:left;padding-left:10px;font:normal 15px sans-serif;color:#000;">
        <table cellspacing="0" cellpadding="0" >
            <tr>
                <td style="width:100px; height:40px;" class="fs14">Bill Title</td>
                <td><input type="text" id="Invoice_Title" value="<?= $Invoice_Title ?>"></td>
                <td rowspan="10" valign="top">
                    <div  style="float:left;text-align:left;"><img src="../../branch_asset/<?= $br ?>.png" style="max-height:500px;"></div>
                </td>
            </tr>
            <tr>
                <td  class="fs14" valign="top" style="height:110px;">Address Title</td>
                <td valign="top" ><textarea class="fs14" id="Address_Title" style="height:100px;width:250px"><?= $Address_Title ?></textarea></td>
            </tr>
            <tr>
                <td class="fs14" style="height:40px;">TAX ID</td>
                <td><input type="text" id="TAXID"  value="<?= $TAXID ?>"></td>
            </tr>
            <tr>
                <td class="fs14" style="height:40px;">POS ID</td>
                <td><input type="text" id="POSID"  value="<?= $POSID ?>"></td>
            </tr>
            <tr>
                <td class="fs14" style="height:40px;">Queue Dialog</td>
                <td><input  data-role="flipswitch" type="checkbox" id="Queue"  value="1" <?php
                    if ($Queue) {
                        echo "checked='checked'";
                    }
                    ?>>
                </td>
            </tr>
            <tr>
                <td class="fs14" style="height:40px;">Member Name</td>
                <td><input  data-role="flipswitch" type="checkbox" id="Member_Name"  value="1" <?php
                    if ($Member_Name) {
                        echo "checked='checked'";
                    }
                    ?>>
                </td>
            </tr>
            <tr>
                <td class="fs14" style="height:40px;">Member Point</td>
                <td><input  data-role="flipswitch" type="checkbox" id="Member_Point"  value="1" <?php
                    if ($Member_Point) {
                        echo "checked='checked'";
                    }
                    ?>>
                </td>
            </tr>
            <tr>
                <td class="fs14" valign="top" style='padding-top:8px;'>Optional Footer<div style='font-size:12px;color:#555;'>Comma Separated</div></td>
                <td valign='top'><textarea id="Footer_Option" style="height:100px;width:250px"><?= $Footer_Option ?></textarea></td>
            </tr>
            <tr>
            <tr>
                <td class="fs14" valign="top" style='padding-top:8px;'>Footer</td>
                <td valign='top'><textarea id="Footer" style="height:100px;width:250px"><?= $Footer ?></textarea></td>
            </tr>
            <tr>
                <td class="fs14" style="height:40px;">Logo</td>
                <td><input type="file" id="logo"></td>
            </tr>
            <tr>
                <td colspan='2'><button class="ui-btn ui-btn-icon-left ui-icon-save ui-btn-corner-all ui-btn-inline ui-btn-b" onclick="save_settings();">Save Settings</button></td>
            </tr>

        </table>
    </div>

</div>
<?php
if ($SESSION_FUNC_DELIVERY) {
    ?>

    <div class="setting-box">
        <h2 class="setting-title">Delivery Rules</h2>
        <table class="main-table">
            <tr>
                <th>Quantity ≥</th>
                <td><input style="text-align:right;width:80px;" type="number" id="Delivery_Min_Item" value="<?= $Delivery_Min_Item ?>"><span class="fs12 gray" style="margin-left:10px">Member can checkout if the total <u>Order Quantity</u> equal or more than specified</span></td>
            </tr>
            <tr>
                <td style="text-align:right">or</td>
                <td></td>
            </tr>
            <tr>
                <th>Price ≥</th>
                <td><input style="text-align:right;width:80px;" type="number" id="Delivery_Min_Baht" value="<?= $Delivery_Min_Baht ?>"><span class="fs12 gray" style="margin-left:10px">Member can checkout if the total <u>Order Price</u> equal or more than specified</span></td>
            </tr>
            <tr>
                <td colspan='2'><button class="ui-btn ui-btn-icon-left ui-icon-save ui-btn-corner-all ui-btn-inline ui-btn-b" onclick="save_delivery_rules()">Save Changes</button></td>
            </tr>
        </table>
    </div>
    <div class="setting-box">
        <h2 class="setting-title">Delivery Location
            <div style='float:right' onclick="$('#delivery_location_form').slideToggle(150);"><img src='../../img/action/add.png'></div>
        </h2>
        <div id='delivery_location_form' style='background-color:#444;color:#000;padding:30px;display:none;'>
            <div style='float:left;color:#fff;padding:15px 5px;' class='fs20'>New Location : </div>
            <div style='float:left;'> <input type='text' class='fs30' style='height:50px;' id='add_delivery_location'></div>
            <div style='float:left;'><button class='submit-button' style="background:url('../../img/button/button_gray.png');border-color:#505a50;" onclick='add_delivery_location()'>Add Location</button></div>
            <div style='clear:both;'></div>
        </div>
        <?php
        $sql_loc = "SELECT * FROM delivery_location WHERE BranchID='$br' ORDER BY Location";
        $result_loc = $conn_db->query($sql_loc);
        while ($db_loc = $result_loc->fetch_array()) {
            $LocationID = $db_loc['ID'];
            $Location_Name = $db_loc['Location'];
            $Location_Active = $db_loc['Active'];

            $Location_Area = "<div class='location-box' id='delivery_$LocationID' onclick=\"remove_delivery_location('$LocationID');\">" . $Location_Name . "</div>";
            $Total_Location = $Total_Location . $Location_Area;
        }
        ?>
        <div id='delivery_location_list'><?= $Total_Location ?></div>
        <div style='clear:both;'></div>
    </div>
    <?php
}
?>
