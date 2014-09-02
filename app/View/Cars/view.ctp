<div class="cars view">
<h2><?php echo __('Car'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($car['Car']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($car['Car']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hsn'); ?></dt>
		<dd>
			<?php echo h($car['Car']['hsn']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tsn'); ?></dt>
		<dd>
			<?php echo h($car['Car']['tsn']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($car['Car']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($car['Car']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Car'), array('action' => 'edit', $car['Car']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Car'), array('action' => 'delete', $car['Car']['id']), null, __('Are you sure you want to delete # %s?', $car['Car']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Cars'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Car'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tires'), array('controller' => 'tires', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tire'), array('controller' => 'tires', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Problems'), array('controller' => 'problems', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Problem'), array('controller' => 'problems', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Tires'); ?></h3>
	<?php if (!empty($car['Tire'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Car Id'); ?></th>
		<th><?php echo __('Brand'); ?></th>
		<th><?php echo __('Produced At'); ?></th>
		<th><?php echo __('Profile1'); ?></th>
		<th><?php echo __('Profile2'); ?></th>
		<th><?php echo __('Profile3'); ?></th>
		<th><?php echo __('Profile4'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($car['Tire'] as $tire): ?>
		<tr>
			<td><?php echo $tire['id']; ?></td>
			<td><?php echo $tire['car_id']; ?></td>
			<td><?php echo $tire['brand']; ?></td>
			<td><?php echo $tire['produced_at']; ?></td>
			<td><?php echo $tire['profile1']; ?></td>
			<td><?php echo $tire['profile2']; ?></td>
			<td><?php echo $tire['profile3']; ?></td>
			<td><?php echo $tire['profile4']; ?></td>
			<td><?php echo $tire['modified']; ?></td>
			<td><?php echo $tire['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'tires', 'action' => 'view', $tire['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'tires', 'action' => 'edit', $tire['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'tires', 'action' => 'delete', $tire['id']), null, __('Are you sure you want to delete # %s?', $tire['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Tire'), array('controller' => 'tires', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Problems'); ?></h3>
	<?php if (!empty($car['Problem'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Problem Location Id'); ?></th>
		<th><?php echo __('Priority Id'); ?></th>
		<th><?php echo __('Troubleshooting Id'); ?></th>
		<th><?php echo __('Solved'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($car['Problem'] as $problem): ?>
		<tr>
			<td><?php echo $problem['id']; ?></td>
			<td><?php echo $problem['description']; ?></td>
			<td><?php echo $problem['problem_location_id']; ?></td>
			<td><?php echo $problem['priority_id']; ?></td>
			<td><?php echo $problem['troubleshooting_id']; ?></td>
			<td><?php echo $problem['solved']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'problems', 'action' => 'view', $problem['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'problems', 'action' => 'edit', $problem['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'problems', 'action' => 'delete', $problem['id']), null, __('Are you sure you want to delete # %s?', $problem['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Problem'), array('controller' => 'problems', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
