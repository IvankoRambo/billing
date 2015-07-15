(function($){
	
	$('.new_products_table').hide();
	
	
	var Product = {
		init: function(){
			this.template = '<tr><td>{{name}}</td><td>{{description}}</td><td>{{price}}</td><td><a href="single-product?product_id={{id}}" class="btn btn-info pull-right"><span class="glyphicon glyphicon-pencil"></span></a></td></tr>';
			this.query;
			this.products = [];
			this.timer;
			this.fetch;
			this.parse;
			
			this.cache();
			this.bindEvents();
			this.subscriptions();
			
			return this;
		},
		
		cache: function(){
			//this.container = $('#products_tr');
			this.searchInput = $('#product-search');
			this.oldTable = $('#old_prod');
		},
		
		bindEvents: function(){
			this.searchInput.on('keyup', this.search);
		},
		
		subscriptions: function(){
			this.fetch = $.Callbacks();
			this.fetch.add(this.fetchJSON);
			this.parse = $.Callbacks();
			this.parse.add(this.parseResults);
		},
		
		search: function(){
			var self = Product,
			input = this;
			
			if(input.value){
					self.oldTable.hide();
					$('.new_products_table').show();
			}
			else{
					self.oldTable.show();
					$('.new_products_table').hide();
			}
			
			clearTimeout(self.timer);
			
			self.timer = (input.value.length >= 1) && setTimeout(function(){
				self.query = input.name+'='+input.value;
				self.fetch.fire();
			}, 200)
			
		},
		
		fetchJSON: function(){
			var path = 'product-search';
			
			return $.post(path, Product.query, function(data){
				Product.products = JSON.parse(data);
				Product.parse.fire();
			});
		},
		
		parseResults: function(){
			var self = Product;
			self.frag = '';
			
		
			if(self.products.success){
			
				
				$.each(self.products.data, function(index, obj){
					self.frag += 
						self.template.replace(/{{name}}/ig, obj.name)
						.replace(/{{description}}/ig, obj.description)
						.replace(/{{price}}/ig, obj.price)
						.replace(/{{id}}/ig, obj.id);
				});
				
			}
			else{
				self.frag = '<td>There is no product with such name</td>';
			}
			
			$('#new_thead').empty().append(self.frag);
			
		}
		
	}
	
	Product.init();

	
})(jQuery)
