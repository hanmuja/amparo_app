<table width="700px" style="font-family : Arial, Verdana, Helvetica, sans-serif;">
<tr>
<td>
<table width="100%">
  <tr>
    <td colspan="2" style="background-color: #9F1A1A; color: white;"><?php echo __("Week")." ".$one['Week']['week_number'] ?> <span class="yellow">|</span> <?php echo date('F d, Y', $one['Week']['initial_date'])." ".__("to")." ".date('F d, Y', $one['Week']['final_date']); ?> <span class="yellow">|</span> <?php echo $one["User"]["fullname"]?></td>
  </tr>
  <tr>
    <td style="border: 1px solid #B9BCC3;">
      <div style="float:left; margin: 10px 30px 0 30px;"><h3>JFH Technologies Timesheet</h3></div>
      <div style="float:right; margin: 0 30px;">
        <p style="font-size:110%">
          <?php echo $this->Html->tag('span', __("Total Hours:"), array('style' => 'font-weight:bold;'))." ".$totals['hours']['total']; ?><br />
          <?php echo $this->Html->tag('span', __("Total Miles:"), array('style' => 'font-weight:bold;'))." ".$totals['mileages']['total']; ?><br />
          <?php echo $this->Html->tag('span', __("Total Tolls:"), array('style' => 'font-weight:bold;'))." ".$this->Number->currency($totals['tolls']['total'], 'USD'); ?><br />
        </p>
      </div>
    </td>
    <td style="border: 1px solid #B9BCC3;">
      <div style="padding: 5px;">
        <?php echo $this->Html->tag('span', __("Name:"), array('style' => 'font-weight:bold;'))." ".$one['User']['first_name']." ".$one['User']['last_name']; ?><br />
        <?php echo $this->Html->tag('span', __("Employee Number:"), array('style' => 'font-weight:bold;'))." ".$one['User']['employee_number']; ?><br />
        <?php echo $this->Html->tag('span', __("Username:"), array('style' => 'font-weight:bold;'))." ".$one['User']['username']; ?><br />
        <?php echo $this->Html->tag('span', __("Phone Number:"), array('style' => 'font-weight:bold;'))." ".$one['User']['phone']; ?><br />
        <?php echo $this->Html->tag('span', __("Email:"), array('style' => 'font-weight:bold;'))." ".$one['User']['email']; ?>
      </div>
    </td>
  </tr>
</table>
<br />
<br />
</td>
</tr>
<tr>
<td>
<?php
foreach($one['Day'] as $day)
{ 
$no_information = "No Information Provided";

$checkin = $day['is_empty'] ? "None" : $day['checkin'];
$checkout = $day['is_empty'] ? "None" : $day['checkout'];

?>
<table width="100%" style="border: 1px solid #B9BCC3; text-align: left;">
  <thead>
    <th colspan="<?php echo $day['is_empty'] ? 1 : 3 ?>" style="background-color: #CCCCCC">
      <?php echo $day['day_name']." ".date('F d, Y', $day['date_day'])."<div style=\"float: right;\">Clock In: <b>".$checkin."</b> - Clock Out: <b>".$checkout."</b></div>" ?>
    </th>
  </thead>
  <tbody>
    <?php if($day['is_empty']): ?>
      <tr>
        <td class="no_item_td" colspan="100%"><div style="background-color: #DEDEF1; font-size: 12px; margin: 5px; padding: 10px 10px 10px 24px;"><?php echo $no_information ?></div></td>
      </tr>
    <?php else: ?>
      <tr>
        <td valign="top" style="border: 1px solid #B9BCC3;">
          <table width="100%" colspace="0" style="border-collapse: collapse; text-align: left;">
            <thead colspan="100%" style="background-color: #DA1B1B; color: white;">
              <th>Location</th>
              <th>Hours</th>
            </thead>
            <tbody>
              <?php if(count($day['DailyTime']) > 0): ?>
                <?php foreach($day['DailyTime'] as $daily_time): ?>
                <tr>
                  <?php $minutes = strlen($daily_time['minutes']) == 1 ? '0'.$daily_time['minutes'] : $daily_time['minutes']; ?>
                  <td style="padding: 0 2px;"><?php echo $daily_time['Location']['name'] ?></td>
                  <td style="padding: 0 2px;"><?php echo $daily_time['hours'].":".$minutes ?></td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td class="no_item_td" colspan="100%"><div style="background-color: #DEDEF1; font-size: 12px; margin: 5px; padding: 10px 10px 10px 24px;"><?php echo $no_information ?></div></td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </td>
        <td valign="top" style="border: 1px solid #B9BCC3;">
          <table width="100%" colspace="0" style="border-collapse: collapse; text-align: left;">
            <thead colspan="100%" style="background-color: #DA1B1B; color: white;">
              <th>From</th>
              <th>To</th>
              <th>RT</th>
              <th>Miles</th>
            </thead>
            <tbody>
              <?php if(count($day['DailyMileage']) > 0): ?>
                <?php foreach($day['DailyMileage'] as $daily_mileage): ?>
                <tr>
                  <td style="padding: 0 2px;"><?php echo $daily_mileage['FromLocation']['name'] ?></td>
                  <td style="padding: 0 2px;"><?php echo $daily_mileage['ToLocation']['name'] ?></td>
                  <td style="padding: 0 2px;"><?php echo $daily_mileage['round_trip'] ? 'Yes' : 'No' ?></td>
                  <td style="padding: 0 2px;"><?php echo $this->Utils->getMiles($daily_mileage) ?></td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td class="no_item_td" colspan="100%"><div style="background-color: #DEDEF1; font-size: 12px; margin: 5px; padding: 10px 10px 10px 24px;"><?php echo $no_information ?></div></td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </td>
        <td valign="top" style="border: 1px solid #B9BCC3;">
          <table width="100%" colspace="0" style="border-collapse: collapse; text-align: left;">
            <thead colspan="100%" style="background-color: #DA1B1B; color: white;">
              <th colspan="2">Totals</th>
            </thead>
            <tbody>
              <tr>
                <td style="padding: 0 2px;">Total Hours</td>
                <td style="text-align: right; padding: 0 2px;"><?php echo $totals['hours'][$day['id']] ?></td>
              </tr>
              <tr>
                <td style="padding: 0 2px;">Additional Miles</td>
                <td style="text-align: right; padding: 0 2px;"><?php echo $day['additional_mileage'] ?></td>
              </tr>
              <tr>
                <td style="padding: 0 2px;">Total Miles</td>
                <td style="text-align: right; padding: 0 2px;"><?php echo $totals['mileages'][$day['id']] ?></td>
              </tr>
              <tr>
                <td style="padding: 0 2px;">Tolls</td>
                <td style="text-align: right; padding: 0 2px;"><?php echo $this->Number->currency($day['tolls'], 'USD') ?></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <?php echo $day['comments'] ?>
        </td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>
<br />
<br />
  <?php
}
?>
</td>
</tr>
</table>