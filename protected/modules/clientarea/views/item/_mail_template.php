    <?php
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 26-01-2015
    * Time :03:19 AM
    *  @var $params Array
    */
    ?> 

    <div>
            Dear Customer,</div>
    <div>
            &nbsp;</div>
    <div>
            Thanks for your business.</div>
    <div>
            &nbsp;</div>
    <div>
            The item is attached with this mail. You can choose the easy way out and <a href="http://yiioverflow.com" target="_blank">pay online for this.</a></div>
    <div>
            &nbsp;</div>
    <div>
            Here is the overview of the reference.</div>
    <div>
            &nbsp;</div>
    <div>
            Overview</div>
    <div>
            Date : <?php echo $params['date']; //Additional Messages will be displayed here.?> </div></div>
    <div>
            Amount : PLN <?php echo $params['amount']; ?> </div></div>
    <div>
            &nbsp;</div>
    <div>
            It was great working with you. Looking forward to working with you again.</div>
    <div>
            &nbsp;</div>
    <div>
            Regards</div>
    <div>
            <?php echo ucfirst($params['signature']); ?>.</div>
