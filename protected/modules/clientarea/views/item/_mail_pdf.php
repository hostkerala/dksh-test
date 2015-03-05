<?php 
$model = new Item('search');
$model->unsetAttributes();
$model->id = $selectedItems;
$data_provider = $model->search();
$items = $data_provider->getData();
if(!empty($items))
{
    foreach($items as $data):
    ?>
        <page orientation="paysage" >
                <bookmark title="Document" level="0" ></bookmark>
                <table align="right" cellspacing="0" style="width: 50%;">
                <tr>
                    <td colspan="4" style="background-color:#E4E4E3;text-align:center;border: solid 1px #000000;"><?php echo $data->category->category_title; ?></td>			
                </tr>            
                <tr>
                    <td style="width: 25%; border: solid 1px #000000;">Create time:</td>
                    <td style="width: 30%; border: solid 1px #000000;"><?php echo $data->item_create_time  ?></td>
                    <td style="width: 25%; border: solid 1px #000000;">Submit time:</td>
                    <td style="width: 20%; border: solid 1px #000000;"><?php echo $data->item_submit_time;  ?></td>
                </tr>
                <tr>
                    <td style="width: 25%; border: solid 1px #000000;">End time:</td>
                    <td style="width: 30%; border: solid 1px #000000;"><?php echo $data->item_end_time; ?></td>
                    <td style="width: 25%; border: solid 1px #000000;">Type:</td>
                    <td style="width: 20%; border: solid 1px #000000;"><?php echo $data->item_type; ?></td>
                </tr>
                </table>    
                <br />
                <?php if(!empty($data->client)):?>                
                <table cellspacing="0" style="width: 100%;">    
                    <tr>
                        <?php $i = 0; foreach($data->client as $client): ?>                        
                            <td>
                                <table cellspacing="0" style="width: 100%;">
                                    <tr>
                                        <td style="width: 30%; font-size: 10pt;">
                                            <br>
                                            <b><?php echo $client->client_name;  ?></b><br>
                                               <?php echo $client->client_street;  ?><br>                                            
                                               <?php echo $client->client_city;  ?><br>
                                               <?php echo $client->client_post_code;  ?><br>
                                            <br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        <?php  $i = $i + 1; 
                               if($i>3)
                               {
                                   $i =0;
                                   echo "</tr><tr>";
                               }
                        
                        endforeach; ?>
                    </tr>
                </table>
                <?php
                endif;?>
                <br /><br /><br />
                <hr />
                <?php if(!empty($data->additional_data)) { ?>                   
                    <table cellspacing="0" style="padding: 1px; width: 100%;font-size: 10pt; ">
                        <tr>
                            <td style="width: 10%; border: solid 1px #000000;">Lp</td>
                            <td style="width: 25%; border: solid 1px #000000;">Name</td>
                            <td style="width: 10%; border: solid 1px #000000;">Yii</td>
                            <td style="width: 10%; border: solid 1px #000000;">Unit</td>
                            <td style="width: 10%; border: solid 1px #000000;">Quantity</td>
                            <td style="width: 10%; border: solid 1px #000000;">Netto1</td>
                            <td style="width: 10%; border: solid 1px #000000;">Rate</td>
                            <td style="width: 5%; border: solid 1px #000000;">Net</td>                                
                        </tr>
                        <?php $n = 1; foreach($data->additional_data as $row):?>
                        <tr>
                            <td style="width: 10%; border: solid 1px #000000;"><?php echo $row['name'];  ?></td>
                            <td style="width: 25%; border: solid 1px #000000;"><?php echo $row['yii'];  ?></td>
                            <td style="width: 10%; border: solid 1px #000000;"><?php echo $row['unit'];  ?></td>
                            <td style="width: 10%; border: solid 1px #000000;"><?php echo $row['quantity'];  ?></td>
                            <td style="width: 10%; border: solid 1px #000000;"><?php echo $row['netto1'];  ?></td>
                            <td style="width: 10%; border: solid 1px #000000;"><?php echo $row['rate'];  ?></td>
                            <td style="width: 10%; border: solid 1px #000000;"><?php echo $row['netto2'];  ?></td>
                            <td style="width: 5%; border: solid 1px #000000;"><?php echo $row['total'];  ?></td>                                
                        </tr>
                        <?php $n += 1; endforeach; ?>
                    </table>
                <?php } ?>
                <br /><br /><br />
                <table cellspacing="0" align="left" style="padding: 1px; width: 60%;font-size: 10pt; ">
                    <tr>
                        <td style="width: 25%; border: solid 1px #000000;">Rate</td>
                        <td style="width: 25%; border: solid 1px #000000;">Netto1</td>
                        <td style="width: 25%; border: solid 1px #000000;">Diff</td>
                        <td style="width: 25%; border: solid 1px #000000;">Total</td>                             
                    </tr>
                    <tr>
                        <td style="width: 25%; border: solid 1px #000000;"><?php echo $row['rate'];  ?></td>
                        <td style="width: 25%; border: solid 1px #000000;"><?php echo $row['netto1'];  ?></td>
                        <td style="width: 25%; border: solid 1px #000000;"><?php echo $row['total'];  ?></td>
                        <td style="width: 25%; border: solid 1px #000000;"><?php $diff =  $row['total'] - $row['netto1']; ; echo $diff;  ?></td>                              
                    </tr>
                </table>
                <table cellspacing="0" align="right" style="text-align:right; padding: 1px; width: 40%;font-size: 10pt; ">
                    <tr>
                        <td style="width: 70%;">Amount :</td>
                        <td style="width: 30%;"><?php echo $data->item_amount; ?> PLN</td>

                    </tr>
                    <tr>
                        <td style="width: 70%;">Amount Left :</td>
                        <td style="width: 30%;"><?php echo $data->item_amount_left; ?></td>                                
                    </tr>
                    <tr>
                        <td style="width: 70%;">Total Sum :</td>
                        <td style="width: 30%;"><?php echo $data->item_total; ?></td>                          
                    </tr>
                </table>     
            </page>
    <?php endforeach; 
}