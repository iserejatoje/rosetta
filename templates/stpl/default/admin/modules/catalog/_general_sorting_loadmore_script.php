<script>
	$(function() {
		var LoadMore = function() {
			function LoadMore() {
				this.page = 1;
				this.perPage = 15;
				this.delay = 2000;
				this.isLoading = false;
				this.container = document.getElementById("grid-container");
				this._init();
			}

			LoadMore.prototype._init = function() {
				this._load();
				this.interval = setInterval(this._load.bind(this), this.delay);
			}

			LoadMore.prototype._buildQuery = function() {
				var query = '',
					params = {
						action: "general_sorting_load_more",
						section_id: <?= $vars['section_id'] ?>,
						type_id: <?= json_encode($vars['type_id']) ?>,
                        actual: <?= $vars['actual'] ?>,
						page: this.page,
						perPage: this.perPage,
					};

				for(var key in params) {
					var value = params[key];
					query += encodeURIComponent(key) + "=" + encodeURIComponent(value) + "&";
				}

				query = query.substring(0, query.length - 1); //chop off last "&"
				return '?' + query;
			}

			LoadMore.prototype._load = function() {
				if(this.isLoading)
					return;

				this.isLoading = true;

				var xhr = new XMLHttpRequest();
				xhr.open('GET', this._buildQuery(), false);
				xhr.send();
				if (xhr.status == 200) {
					var response = JSON.parse(xhr.responseText);
					if(response.status == "ok") {
						this.container.insertAdjacentHTML('beforeend', response.content);
						this.isLoading = false;
					} else {
						clearInterval(this.interval);
					}
				} else {
					console.log('server error');
					console.log('code: ' + xhr.status);
					console.log('message: ' + xhr.responseText);
					return;
				}

				this.page++;
			}

			return new LoadMore();
		}

		LoadMore();
	});

</script>