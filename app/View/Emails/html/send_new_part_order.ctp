<div class="header_part_order">
    Location: <?php echo $one['Problem']['Equipment']['Location']['name'] ?><br />
    Game: <?php echo $one['Problem']['Equipment']['Game']['name'] ?><br />
    Order By: <?php echo $one['Creator']['first_name'] ?> <?php echo $one['Creator']['last_name'] ?><br />
</div>
<br />
<br />
<br />
<table width="700px" style="font-family : Arial, Verdana, Helvetica, sans-serif;">
  <?php if(count($one['PartOrderComponent']) > 0): ?>
  <tr>
    <td>
      <table width="100%" colspace="0" style="border-collapse: collapse; text-align: left; border: 1px solid #B9BCC3;">
        <thead>
          <th colspan="3" style="background-color: #CCCCCC">Related Parts</th>
        </thead>
        <tr style="background-color: #DA1B1B; color: white;">
          <td>Related Parts to Order</td>
          <td>Units</td>
          <td>Date Needed</td>
        </tr>
        <?php foreach($one['PartOrderComponent'] as $component): ?>
          <tr>
            <td><?php echo $component['Part']['part_number'].": ".$component['Part']['description'] ?></td>
            <td><?php echo $component['units'] ?></td>
            <td><?php echo $component['expected_arrival_date'] ? date('m-d-Y', $component['expected_arrival_date']) : '' ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </td>
  </tr>
  <?php endif; ?>
  <?php if($count_non_related > 0): ?>
  <tr>
    <td>
      <table width="100%" colspace="0" style="border-collapse: collapse; text-align: left; border: 1px solid #B9BCC3;">
        <thead>
          <th colspan="3" style="background-color: #CCCCCC">Non-Related Parts</th>
        </thead>
        <tr style="background-color: #DA1B1B; color: white;">
          <td>Non-Related Parts to Order</td>
          <td>Units</td>
          <td>Date Needed</td>
        </tr>
        <?php foreach($one['PartSuggestion'] as $suggestion): ?>
          <?php if(!$suggestion['Part']['suggested']): ?>
            <tr>
              <td><?php echo $suggestion['Part']['part_number'].": ".$suggestion['Part']['description'] ?></td>
              <td><?php echo $suggestion['units'] ?></td>
              <td><?php echo $suggestion['expected_arrival_date'] ? date('m-d-Y', $suggestion['expected_arrival_date']) : '' ?></td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </table>
    </td>
  </tr>
  <?php endif; ?>
  <?php if($count_new > 0): ?>
  <tr>
    <td>
      <table width="100%" colspace="0" style="border-collapse: collapse; text-align: left; border: 1px solid #B9BCC3;">
        <thead>
          <th colspan="3" style="background-color: #CCCCCC">New Parts</th>
        </thead>
        <tr style="background-color: #DA1B1B; color: white;">
          <td>New Part Request Details</td>
          <td>Units</td>
          <td>Date Needed</td>
        </tr>
        <?php foreach($one['PartSuggestion'] as $suggestion): ?>
          <?php if($suggestion['Part']['suggested']): ?>
            <tr>
              <td><?php echo $suggestion['Part']['description'] ?></td>
              <td><?php echo $suggestion['units'] ?></td>
              <td><?php echo $suggestion['expected_arrival_date'] ? date('m-d-Y', $suggestion['expected_arrival_date']) : '' ?></td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </table>
    </td>
  </tr>
  <?php endif; ?>
  <tr>
    <th colspan="3" style="background-color: #CCCCCC; text-align: left;">Order Details</th>
  </tr>
  <tr>
    <td><?php echo $one['PartOrder']['description'] ?></td>
  </tr>
</table>