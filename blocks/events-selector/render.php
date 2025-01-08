<?php
/**
 * ACF Block Template:
 *
 */

namespace SHASS;

global $post;

// INIT Grab fields
$custom_block_data = array(); // Store all values in an array for the block
$custom_block_data['classes'] = 'events-selector sideline'; // Declare first classes
;

// Generate unique block ID
if( empty( $custom_block_data['block_id'] ) ) {
	if( !empty( $block['metadata']['name'] ) ) {
 		$custom_block_data['block_id'] = $block['metadata']['name'];
 	} else {
 		$custom_block_data['block_id'] = 'eventsselector_' . str_replace('block_', '', $block['id']);
 	}
}

include(dirname(__FILE__) . '/../block-meta.php');

// pr($fields['es_departments']);

?>
<section id="<?php echo esc_html( $custom_block_data['block_id'] ); ?>" class="<?php echo esc_html( $custom_block_data['classes'] ); ?>">
	<div class="block-content">

		<script src="//unpkg.com/vue@3/dist/vue.global.prod.js"></script>

		<div id="app" class="events-frame">

			<div class="events-frame--cards">

				<div v-if="isLoading" class="body-content events-frame--meta">
					<h2 class="header">Loading events...</h2>
				</div>

				<div v-if="!isLoading && events.length == 0" class="body-content events-frame--meta">
					<h2 class="header">No events scheduled for {{currDept}} </h2>
				</div>

				<a v-if="!isLoading" v-for="(item, ndx) in events"
					class="card listing"
					:href="item.event.localist_url"
					target="_blank">
					<img :src="item.event.photo_url" alt="" />
					<div class="card-content">

						<div class="title-leads-set">
							<h3>{{ item.event.title }}</h3>

							<div class="event-card-meta">
								<span>{{ cookDate(item.event.event_instances[0].event_instance.start) }}</span>
								<span>{{ cookTime(item.event.event_instances[0].event_instance.start) }} - {{ cookTime(item.event.event_instances[0].event_instance.end) }}</span>
							</div>
						</div>
						<p>{{ trunc(item.event.description_text) }} [read more]</p>

						<?php getIcon('arrow-northeast') ?>
					</div>
				</a>
			</div>

			<div class="events-frame--selector">
				<div class="eyebrow">Filter By</div>
				<ul>
					<li :class="{ 'sel': activeTab == 0 }" @click="getFeed(allRoot, 0)" data-dept="all">All SHASS Events</li>
					<?php foreach($fields['es_departments'] as $coun => $dept) {
						if(!$dept['id']) { $dept['id'] = 'a'; }
						echo '<li :class="{ \'sel\': activeTab == '.($coun+1).' }" data-dept="'.$dept['id'].'" @click="getFeed('.$dept['id'].','.($coun + 1).')">'.$dept['label'].'</li>';
					} ?>
				</ul>
			</div>
		</div>

		<script>
			document.addEventListener("DOMContentLoaded", function(e) {
				const { createApp, ref } = Vue

				const depts = document.querySelectorAll('[data-dept]');
				const eventsFrame = document.querySelector('.events-frame');
				let currDept = 'All SHASS Events';

				const rightNow = new Date();
				const monthDay = '-'+(rightNow.getMonth() + 1)+'-'+rightNow.getDate();
				const startDate = rightNow.getFullYear()+monthDay;
				const endDate = (rightNow.getFullYear() + 1)+monthDay;

				const rootie = 'https://calendar.mit.edu/api/2/events?start='+startDate+'&end='+endDate+'&pp=100';

				const allRoot = 'https://calendar.mit.edu/api/2/events?start='+startDate+'&end='+endDate+'&pp=100&type=103364'; // All SHASS
				const groupRoot = 'https://calendar.mit.edu/api/2/events?start='+startDate+'&end='+endDate+'&pp=100&type=103364&group_id='; // category // 10110

				const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
				const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

				function cookDate(q) {
					const theDate = new Date(q);
					const theDateString = dayNames[theDate.getDay()] + ', ' + monthNames[theDate.getMonth()] + ' ' + theDate.getDate() + ', ' + theDate.getFullYear();
					return theDateString;
				}

				function cookTime(q) {
					const theTime = new Date(q).toLocaleString('en-us', { hour: 'numeric', minute: '2-digit', hourCycle: 'h12', timeZone: 'America/New_York' });
					return theTime;
				}

				function trunc(q, x = 18) {
					return q.split(' ').splice(0, x).join(' ');
				}

				<?php // let's do some Vue ?>

				createApp({

					setup() {
						const events = ref({});
						const feed = ref({});
						let activeTab = ref(0);
						let isLoading = ref(false);

						function getFeed(q, ndx, ig = null) {

							if(!depts[ndx].classList.contains('sel') || ig == true) {

								activeTab.value = ndx;
								isLoading.value = true;

								if(ndx > 0) { this.currDept = depts[ndx].textContent }
								// console.log(depts[ndx].textContent);

								if(q !== allRoot) { q = groupRoot + q; }

				 				fetch(q, {
				 				    method: 'GET' //optional
				 				})
				 				  .then(async (response) => {
				 				  	isLoading.value = false;
				 				    const data = await response.json()
				 				    console.log("from API", data);
			 				    	this.events = data.events;

				 				  })
				 				  .catch((error) => {return error}) /**/
				 			}
						}

						return {
							activeTab,
							allRoot,
							cookDate,
							cookTime,
							currDept,
							depts,
							events,
							feed,
							getFeed,
							groupRoot,
							isLoading,
							trunc
						}
					},
					async created() {
						this.getFeed(allRoot,0,true);
					},
				}).mount('#app')
			});
		</script>
	</div>
</section>
