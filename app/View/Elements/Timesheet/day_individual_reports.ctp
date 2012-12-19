<?php $no_information = __("No Information Provided"); ?>

<?php 

$checkin = $day['is_empty'] ? "None" : $day['checkin'];
$checkout = $day['is_empty'] ? "None" : $day['checkout'];
echo $this->Utils->form_section($day['day_name']." ".date('F d, Y', $day['date_day'])."<div style=\"float: right;\">Clock In: <b>".$checkin."</b> - Clock Out: <b>".$checkout."</b></div>");

?>
<table>
  <tbody>
    <?php if($day['is_empty']): ?>
      <tr>
        <td class="no_item_td" colspan="100%"><div class="infobox"><?php echo $no_information ?></div></td>
      </tr>
    <?php else: ?>
      <tr>
        <td valign="top">
          <table class="promana-head-button">
            <thead>
              <th><?php echo __("Location") ?></th>
              <th><?php echo __("Hours") ?></th>
            </thead>
            <tbody>
              <?php if(count($day['DailyTime']) > 0): ?>
                <?php foreach($day['DailyTime'] as $daily_time): ?>
                <tr>
                  <td><?php echo $daily_time['Location']['name'] ?></td>
                  <?php $minutes = strlen($daily_time['minutes']) == 1 ? '0'.$daily_time['minutes'] : $daily_time['minutes']; ?>
                  <td><?php echo $daily_time['hours'].":".$minutes ?></td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td class="no_item_td" colspan="100%"><div class="infobox"><?php echo $no_information ?></div></td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </td>
        <td valign="top">
          <table class="promana-head-button">
            <thead>
              <th><?php echo __("From") ?></th>
              <th><?php echo __("To") ?></th>
              <th><?php echo __("RT") ?></th>
              <th><?php echo __("Miles") ?></th>
            </thead>
            <tbody>
              <?php if(count($day['DailyMileage']) > 0): ?>
                <?php foreach($day['DailyMileage'] as $daily_mileage): ?>
                <tr>
                  <td><?php echo $daily_mileage['FromLocation']['name'] ?></td>
                  <td><?php echo $daily_mileage['ToLocation']['name'] ?></td>
                  <td><?php echo $daily_mileage['round_trip'] ? 'Yes' : 'No' ?></td>
                  <td><?php echo $this->Utils->getMiles($daily_mileage) ?></td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td class="no_item_td" colspan="100%"><div class="infobox"><?php echo $no_information ?></div></td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </td>
        <td valign="top">
          <table class="promana-head-button">
            <thead>
              <th colspan="2"><?php echo __("Totals") ?></th>
            </thead>
            <tbody>
              <tr>
                <td><?php echo __("Total Hours") ?></td>
                <td style="text-align: right;"><?php echo $totals['hours'][$day['id']] ?></td>
              </tr>
              <tr>
                <td><?php echo __("Additional Miles") ?></td>
                <td style="text-align: right;"><?php echo $day['additional_mileage'] ?></td>
              </tr>
              <tr>
                <td><?php echo __("Total Miles") ?></td>
                <td style="text-align: right;"><?php echo $totals['mileages'][$day['id']] ?></td>
              </tr>
              <tr>
                <td><?php echo __("Tolls") ?></td>
                <td style="text-align: right;"><?php echo $this->Number->currency($day['tolls'], 'USD') ?></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="100%">
          <?php echo $day['comments'] ?>
        </td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>