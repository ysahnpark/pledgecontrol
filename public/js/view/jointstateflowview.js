
var JointStateflowView = (function() {

	var uml = joint.shapes.uml;
	/**
	 * View for document with multiple children documents
	 * Each of the child document is rendered in a Tab
	 *
	 * @param {string} docViewSelector  The selector wthin the tab that defines the view of a doucment
	 *  
	 */
	var JointStateflowView = function(fillSelectedStateFormFn)
	{
		this.nextPos = {x: 20, y: 20};
		this.selectedState = null;

		this.graph = null;
		this.paper = null;

		this.eventListeners = []; // callback functions funtion(eventName, param)

		this.states = {};
		this.transitions = {};

		this.initState = null; // the initial state which points to the start state.
		this.initTransition = null; // the initial transition to the start state.
		this.selectedCellView = null;

		this.fillSelectedStateForm = fillSelectedStateFormFn;
	}

	JointStateflowView.prototype.addEventListener = function(callbackFn)
	{
		this.eventListeners.push(callbackFn);
	}

	JointStateflowView.prototype.trigger = function(eventName, param)
	{
		for(var i=0; i < this.eventListeners.length; i++) {
			this.eventListeners[i](eventName, param);
		}
	}

	/**
	 * Sets the start state, makes an edge from init node to the start node.
	 */
	JointStateflowView.prototype.setStartStateId = function(startStateId)
	{
		if (!this.states.hasOwnProperty(startStateId)) {
			return;
		}
		this.startStateId = startStateId;
		if (this.startStateId) {
			if (this.initTransition) {
				this.initTransition.remove();
			}
			var initTransition = {
		        source: { id: this.initState.id }, 
				target: { id: this.startStateId }
		    };
		    this.initTransition = new uml.Transition(initTransition);
		    this.graph.addCell(this.initTransition);
		}
	}

	/**
	 * Adds a state
	 * {id: <string>, position:{x, y}, name: <string>, }
	 */
	JointStateflowView.prototype.addState = function(stateInfo, id)
	{
		var stateConfig = {
			name: stateInfo.name,
			size: { width: 160, height: 70 },
			events: []
		};
		if (id) {
			stateConfig['id'] = id;
		}
		if (stateInfo.position) {
			stateConfig['position'] = stateInfo.position;
		}
		if (stateInfo.position) {
			stateConfig['size'] = stateInfo.size;
		}
		if (stateInfo.onEntry) {
			stateConfig['events'].push('entry: ' + stateInfo.onEntry);
		}
		if (stateInfo.onExit) {
			stateConfig['events'].push('exit: ' + stateInfo.onExit);
		} 

		var newState = new uml.State(stateConfig);

	    this.graph.addCell(newState);

	    this.states[newState.id] = newState;

	    stateInfo.id = newState.id;
	    this.states[newState.id] = stateInfo;
	    this.trigger('state:add', stateInfo);
	}

		/**
	 * Adds a state
	 * {id: <string>, position:{x, y}, name: <string>, }
	 */
	JointStateflowView.prototype.addTransition = function (transitionInfo, id)
	{
		var transitionData = { 
			source: { id: transitionInfo.source_id }, 
			target: { id: transitionInfo.target_id }
		};
		if (id) {
			transitionData['id'] = id;
		}
		var newTransition = new uml.Transition(transitionData);

		this.graph.addCell(newTransition);
		this.transitions[newTransition.id] = newTransition;

		transitionInfo.id = newTransition.id;

		this.trigger('transition:add', transitionInfo);
	    this.transitions[newTransition.id] = transitionInfo;
	}


	/**
	 * iniialize
	 * @param containerSelector, 
	 * @param width, 
	 * @param height, 
	 * @param states, 
	 * @param transitions
	 */
	JointStateflowView.prototype.init = function(containerSelector, width, height, states, transitions, startStateId) {
		this.graph = new joint.dia.Graph;
		this.paper = new joint.dia.Paper({
		    el: $(containerSelector),
		    width: width,
		    height: height,
		    gridSize: 1,
		    model: this.graph
		});

		var _this = this; 

		this.graph.on('remove', function(cell) {
			if (cell.attributes.type === "uml.State") {
				// Remove State model
				var removedState = _.cloneDeep(_this.states[cell.id]);
				delete _this.states[cell.id];
				_this.trigger('state:remove', removedState);
				//$scope.$apply();
			}
			if (cell.attributes.type === "uml.Transition") {
				// Remove Transition
				var removedTransition = _.cloneDeep(_this.transitions[cell.id]);
				delete _this.transitions[cell.id];
				_this.trigger('transition:remove', removedTransition);
				//$scope.$apply();
			}
		    console.log(arguments);
		});

		this.graph.on('change:position', function(cell) {
			var pos = cell.get('position');
			_this.trigger('state:changepos', cell);

			_this.states[cell.id].position = pos;
		    //console.log(JSON.stringify(pos));
		});

		// Handle selection of a state
		this.paper.on('cell:pointerclick', 
		    function(cellView, evt, x, y) { 
		        console.log('cell view ' + cellView.model.id + ' was clicked'); 
		        if (_this.selectedCellView) {
		        	_this.selectedCellView.unhighlight();

		        	_this.fillSelectedStateForm({});
		        }
		        if (_this.selectedCellView != cellView) {
			        cellView.highlight();
			        var stateInfo = _this.states[cellView.model.id];

			        stateInfo.isStart = (_this.startStateId === cellView.model.id) 
			        _this.fillSelectedStateForm(stateInfo);
			        _this.selectedCellView = cellView;

			        _this.trigger('state:select', stateInfo);
			    } else {
			    	_this.selectedCellView = null;
			    	_this.trigger('state:noselect', null);
			    }
		    }
		);

		// Add initial state, which points to the start state
		this.initState = new uml.StartState({
	        position: { x:20  , y: 20 },
	        size: { width: 30, height: 30 },
	    });
	    this.graph.addCell(this.initState);

		for(var prop in states) {
			var state = states[prop];
			this.addState(state, prop);
		}

		// Add initial transition
		this.setStartStateId(startStateId);
		

		for(prop in transitions) {
			var trans = transitions[prop];
			this.addTransition(trans);
		}
	}

	JointStateflowView.prototype.updateState = function(stateData)
	{
		var events = [];
		if (stateData.onEntry) {
			events.push('entry: ' + stateData.onEntry);
		}
		if (stateData.onExit) {
			events.push('exit: ' + stateData.onExit);
		} 
		this.selectedCellView.model.set('name', stateData.name);
		this.selectedCellView.model.set({'events': events});


		var stateInfo = this.states[this.selectedCellView.model.id];
		//stateInfo.isStart = stateData.isStart;
		stateInfo.name    = stateData.name;
		stateInfo.onEntry = stateData.onEntry;
		stateInfo.onExit  = stateData.onExit;
		this.trigger('state:update', stateInfo);
	};
	

	JointStateflowView.prototype.newState = function(stateName)
	{
		var stateInfo = {
				type: "start",
		        position: { x: this.nextPos.x  , y: this.nextPos.y },
		        size: { width: 160, height: 70 },
		        name: stateName
		    };

	    this.addState(stateInfo);

		this.nextPos.x += 20;
		this.nextPos.y += 20;
	};

	JointStateflowView.prototype.newTransition = function(targetId, sourceId)
	{
		if (this.selectedCellView === null) {
			return;
		}
		var sourceId = sourceId ? sourceId : this.selectedCellView.model.id;
		var transitionInfo = { 
				source_id: sourceId, 
				target_id: targetId 
			};

	    this.addTransition(transitionInfo);
	};

	return JointStateflowView;
}());