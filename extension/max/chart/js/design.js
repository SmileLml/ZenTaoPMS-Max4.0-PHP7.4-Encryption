var app = new Vue({
    el: '#main',
    data: {
        chart: {type: ''},
        settings: {},
        datasets: [],
        fields: [],
        operators: [],
        fieldMap: {},
        types: [],
        config: {},
        lang: null,
        aggregate: [],
        aggs: [],
        dates: [],
        orders: [],
        orderMap: {},
        filters: [],
        select: {index: 0, field: '', name: ''},
        date: {index: 0, field: '', name: '', group: 'day'},
        formula: {index: 0, field: '', valOrAgg: [], name: ''},
        filter: {index: 0, field: '', operator: '', value: ''},
        order: {index: 0, value: '', sort: 'desc'},
        show: {},
        updated: false,
        chartData: {},
        runError: '',
        showDataset: true,
        fieldsMap: {},
        filterValues: {},
    },
    created() {
        this.chart   = chart;
        this.lang    = lang;
        this.config  = chartConfig;
        this.filters = chart.filters;

        if(this.chart.type.indexOf('Report') !== -1) this.showDataset = false;

        var defaultSettings = {};
        for(let key in this.config[this.chart.type])
        {
            this.show[key] = false;
            defaultSettings[key] = [];
        }
        this.settings = (typeof chart.settings !== 'undefined' && chart.settings) ? JSON.parse(chart.settings) : defaultSettings;

        for(f of this.filters)
        {
            var field = f.field;
            if(f.field.indexOf('.') !== -1)
            {
                var fs = f.field.split('.');
                if(fs[1] == 'id') field = fs[0];
            }
            if(typeof defaults[field] !== 'undefined') this.filterValues[f.field] = defaults[field];
        }

        var fs = [];
        for(var key in fields)
        {
            if(fields[key].type == 'object')
            {
                var children = [];
                var subFields = fields[key].children
                for(var subKey in subFields)
                {
                    children.push({value: key + '.' + subKey, label: subFields[subKey].name, name: fields[key].name + '.' + subFields[subKey].name, type: subFields[subKey].type});
                    subFields[subKey].name = fields[key].name + '.' + subFields[subKey].name;

                    // 筛选过滤需要子字段的options
                    if(typeof subFields[subKey].options !== 'undefined') {
                        let options = [];
                        subFields[subKey].optionMap = subFields[subKey].options;
                        for(let k in subFields[subKey].options) {
                            options.push({value: k, label: subFields[subKey].options[k], name: subFields[subKey].options[k]});
                        }
                        subFields[subKey].options = options;
                    }
                    this.fieldMap[key + '.' + subKey] = subFields[subKey];
                }
                fs.push({value: key, label: fields[key].name, type: fields[key].type, children: children});
            }
            else if(fields[key].type == 'option')
            {
                var options = [];
                for(var opKey in fields[key].options)
                {
                    if(!fields[key].options[opKey]) continue;
                    options.push({value: opKey, label: fields[key].options[opKey], name: fields[key].options[opKey], type: fields[key].type});
                }
                fields[key].optionMap = fields[key].options;
                fields[key].options = options;
                fs.push({value: key, label: fields[key].name, name: fields[key].name, type: fields[key].type, options: options});
                this.fieldMap[key] = fields[key];
            }
            else
            {
                fs.push({value: key, label: fields[key].name, name: fields[key].name, type: fields[key].type});
                this.fieldMap[key] = fields[key];
            }
        }
        this.fields = fs;

        var ds = [];
        for(var key in datasets)
        {
            ds.push({value: key, label: datasets[key]});
        }
        this.datasets = ds;

        var ts = [];
        for(var key in lang.typeList)
        {
            ts.push({value: key, label: lang.typeList[key]});
        }
        this.types = ts;

        var ds = [];
        for(var key in lang.dateList)
        {
            ds.push({value: key, label: lang.dateList[key]});
        }
        this.dates = ds;

        var os = [];
        for(var key in lang.operatorList)
        {
            os.push({value: key, label: lang.operatorList[key]});
        }
        this.operators = os;

        var as = [];
        for(var key in lang.aggList)
        {
            as.push({value: key, label: lang.aggList[key]});
        }
        this.aggregate = as;
        this.loadFilterMap();
    },
    watch: {
        fitlerValues: {
            handler(o, n) {
                console.log(o, n);
            },
            deep: true
        },
    },
    methods: {
        changeType(key) {
            this.updated  = false;
            this.settings = {};
            this.showDataset = this.chart.type == 'report' ? false : true;
        },
        changeField(key) {
            if(this.formula.valOrAgg != 'value' || this.formula.field && this.config[this.chart.type][key].allowed.indexOf('any') === -1 && this.config[this.chart.type][key].allowed.indexOf(this.fieldMap[this.formula.field].type) === -1)
            {
                var aggs = [];
                for(var agg of this.aggregate)
                {
                    if(this.fieldMap[this.formula.field].type !== 'number' && ['count', 'count_distinct', 'value_all', 'value_distinct'].indexOf(agg.value) === -1) continue;
                    aggs.push(agg);
                }
                this.aggs = aggs;
                if(!this.formula.valOrAgg || this.formula.valOrAgg == 'value') this.formula.valOrAgg = 'count';
            }
            else
            {
                var aggs = [];
                for(var agg of this.aggregate)
                {
                    if(this.chart.type == 'table' || this.fieldMap[this.formula.field].type == 'number') aggs.push(agg);
                }
                this.aggs = aggs;
                if(!this.formula.valOrAgg) this.formula.valOrAgg = 'value';
            }
        },
        changeChartFilter() {
            /*
            for(let key in this.filterValues)
            {
                this.$set(this.filterValues, key, this.filterValues[key]);
            }
            */
        },
        changeFilter() {
            this.$set(this.filter, 'value', '');
        },
        updateSettings() {
            var orders = [];
            var orderMap = {};
            for(let key in this.config[this.chart.type])
            {
                if(typeof this.settings[key] == 'undefined') continue;
                for(let index in this.settings[key])
                {
                    var setting = this.settings[key][index];
                    var name = setting.name ? setting.name : ((typeof setting.field.valOrAgg == 'undefined' || setting.field.valOrAgg == 'value') ? this.fieldMap[setting.field].name : (setting.field.valOrAgg.toUpperCase() + '(' + this.fieldMap[setting.field].name + ')'));
                    var value = setting.field + (typeof setting.valOrAgg == 'undefined' || setting.valOrAgg == 'value' ? '' : '/' + setting.valOrAgg);
                    orders.push({value: value, label: name, name: name});
                    orderMap[value] = ({value: value, label: name, name: name});
                }
            }
            this.orders = orders;
            this.orderMap = orderMap;
            this.updated = false;
        },
        hide() {
            this.select  = {index: 0, field: '', name: ''};
            this.formula = {index: 0, field: '', valOrAgg: [], name: ''};
            this.filter  = {index: 0, field: '', operator: '', value: undefined};

            for(let key in this.config[this.chart.type])
            {
                this.$set(this.show, key, false);
            }
            this.$set(this.show, 'filter', false);
            this.$set(this.show, 'order', false);
        },
        reset() {
            this.select   = {index: 0, field: '', name: ''};
            this.formula  = {index: 0, field: '', valOrAgg: '', name: ''};
            this.filter   = {index: 0, field: '', operater: '', value: undefined};
            this.order    = {index: 0, value: '', sort: 'desc'};
            this.runError = '';
        },
        popoverSelect(key, index) {
            this.hide();
            if(typeof index !== 'undefined')
            {
                this.select = {index: index, field: this.settings[key][index].field, name: this.settings[key][index].name};
                if(typeof this.settings[key][index].dateGroup !== 'undefined') this.select.dateGroup = this.settings[key][index].dateGroup;
            }
            else
            {
                this.select = {index: typeof this.settings[key] == 'undefined' ? 0 : this.settings[key].length, field: '', name: ''};
            }
            this.$set(this.show, key, true);
        },
        saveSelect(key) {
            var setting = typeof this.settings[key] == 'undefined' ? [] : this.settings[key];
            setting[this.select.index] = {field: this.select.field, name: this.select.name};
            if(typeof this.select.dateGroup !== 'undefined') setting[this.select.index].dateGroup = this.select.dateGroup;
            this.$set(this.settings, key, setting);
            this.updateSettings();
            this.reset();

            this.$set(this.show, key, false);
        },
        popoverDate(key, index) {
            this.hide();
            if(typeof index !== 'undefined')
            {
                this.date = {index: index, field: this.settings[key][index].field, name: this.settings[key][index].name, group: this.settings[key][index].group};
            }
            else
            {
                this.date = {index: typeof this.settings[key] == 'undefined' ? 0 : this.settings[key].length, field: '', name: '', group: 'day'};
            }
            this.$set(this.show, key, true);
        },
        saveDate(key) {
            var setting = typeof this.settings[key] == 'undefined' ? [] : this.settings[key];
            setting[this.date.index] = {field: this.date.field, name: this.date.name, group: this.date.group};
            this.$set(this.settings, key, setting);
            this.updateSettings();
            this.reset();

            this.$set(this.show, key, false);
        },
        popoverFormula(key, index) {
            this.hide();
            if(typeof index !== 'undefined')
            {
                this.formula = {index: index, field: this.settings[key][index].field, valOrAgg: this.settings[key][index].valOrAgg, name: this.settings[key][index].name, split: this.settings[key][index].split, format: this.settings[key][index].format};
                this.changeField(key);
            }
            else
            {
                this.formula = {index: typeof this.settings[key] == 'undefined' ? 0 : this.settings[key].length, field: '', valOrAgg: 'value',  name: '', split: false};
            }
            this.$set(this.show, key, true);
        },
        changeTab(key) {
            var valOrAgg = this.formula.valOrAgg;
            if(key == 'value')
            {
                valOrAgg = 'value';
            }
            else if(key == 'agg' && valOrAgg == 'value')
            {
                valOrAgg = this.formula.field ? 'count' : '';
            }

            this.$set(this.formula, 'valOrAgg', valOrAgg);
        },
        saveFormula(key) {
            var setting = typeof this.settings[key] == 'undefined' ? [] : this.settings[key];
            setting[this.formula.index] = {field: this.formula.field, valOrAgg: this.formula.valOrAgg, name: this.formula.name};
            if(this.fieldMap[this.formula.field] && this.fieldMap[this.formula.field].type == 'option' && this.formula.split) setting[this.formula.index].split = true;
            if(this.fieldMap[this.formula.field] && this.fieldMap[this.formula.field].type == 'date' && this.formula.format) setting[this.formula.index].format = this.formula.format;

            this.$set(this.settings, key, setting);
            this.updateSettings();

            this.reset();
            this.$set(this.show, key, false);
        },
        popoverFilter(index) {
            this.hide();
            if(typeof index !== 'undefined')
            {
                this.filter = {index: index, field: this.settings.filter[index].field, operator: this.settings.filter[index].operator, value: this.settings.filter[index].value};
            }
            else
            {
                this.filter = {index: typeof this.settings.filter == 'undefined' ? 0 : this.settings.filter.length, field: '', operator: '', value: ''};
            }
            this.$set(this.show, 'filter', true);
        },
        saveFilter() {
            var setting = typeof this.settings.filter == 'undefined' ? [] : this.settings.filter;
            setting[this.filter.index] = {field: this.filter.field, operator: this.filter.operator, value: this.filter.value};
            this.$set(this.settings, 'filter', setting);
            this.updateSettings();

            this.reset();
            this.$set(this.show, 'filter', false);
        },
        popoverOrder(index) {
            this.hide();
            if(typeof index !== 'undefined')
            {
                this.order = {index: index, value: this.settings.order[index].value, sort: this.settings.order[index].sort};
            }
            else
            {
                this.order = {index: typeof this.settings.order == 'undefined' ? 0 : this.settings.order.length, value: '', sort: 'desc'};
            }
            this.$set(this.show, 'order', true);
        },
        saveOrder() {
            if(this.order.value) {
                var setting = typeof this.settings.order == 'undefined' ? [] : this.settings.order;
                setting[this.order.index] = {value: this.order.value, sort: this.order.sort};

                this.$set(this.settings, 'order', setting);
                this.updateSettings();
            }

            this.reset();
            this.$set(this.show, 'order', false);
        },
        changeSplit() {
            this.formula.split = !this.formula.split;
        },
        changePastDays(e) {
            if(typeof this.formula.format == 'undefined') this.formula.format = '';
            this.formula.format = this.formula.format ? '' : 'pastDays';
        },
        deleteSetting(key, index) {
            this.settings[key].splice(index, 1);
            this.updateSettings();
        },
        run() {
            for(var key in this.config[this.chart.type])
            {
                var setting = this.config[this.chart.type][key];
                if(typeof setting.required !== 'undefined' && setting.required)
                {
                    if(typeof this.settings[key] === 'undefined' || this.settings[key].length == 0)
                    {
                        this.runError = this.lang.must + ' "' + this.lang[key] + '"';
                        return;
                    }
                }
            }

            var that = this;
            $.post(createLink('chart', 'ajaxGenChart'), {
                dataset: this.chart.dataset,
                type: this.chart.type,
                settings: this.settings,
                filterValues: this.filterValues,
            }, function(data) {
                var data = JSON.parse(data);
                that.chartData = data;

                if(that.chart.type == 'table')
                {
                    for(var col of data.columns)
                    {
                        if(typeof data.rowspan[col.dataIndex] === 'undefined') continue;

                        (function(col) {
                            var index = col.dataIndex;
                            col.customRender = function(text, row, rowIndex) {
                                if(typeof data.rowspan[index][rowIndex] !== 'undefined') {
                                    return {children: text, attrs: {rowSpan: data.rowspan[index][rowIndex]}};
                                }
                                else
                                {
                                    return {children: text, attrs: {rowSpan: 0}};
                                }
                            }
                        })(col);
                    }
                }
                else if(that.chart.type.indexOf('Report') !== -1)
                {
                    var report = '';
                    for(let table of data.tables)
                    {
                        report += "<table class='table'>";
                        for (let tr of table)
                        {
                            report += "<tr>";
                            for(let td of tr)
                            {
                                let colspan = typeof td.colspan !== 'undefined' ? ' colspan="' + td.colspan + '"' : '';
                                let rowspan = typeof td.rowspan !== 'undefined' ? ' rowspan="' + td.rowspan + '"' : '';
                                report += "<td class='" + (typeof td.cls !== 'undefined' ? td.cls : '') + "' " + rowspan + colspan + ">" + td.value + "</td>";
                            }
                            report += "</tr>";
                        }
                        report += "<table>";
                    }
                    $('#report').html(report);
                }
                else
                {
                    var chart = echarts.init(document.getElementById('draw'));
                    chart.setOption(data, true);
                }
                that.updated = true;
            })
        },
        showField(field, value) {
            if(Array.isArray(value))
            {
                var values = [];
                for(let v of value)
                {
                    values.push(this.fieldMap[field].type == 'option' ? this.fieldMap[field].optionMap[v] : v);
                }
                return values.join(',');
            }
            else
            {
                return this.fieldMap[field].type == 'option' ? this.fieldMap[field].optionMap[value] : value;
            }
        },
        changeDataset(dataset) {
            var that = this;
            $.get(createLink('chart', 'ajaxGetFields', 'dataset=' + dataset), function(fields) {
                that.fieldMap = {};
                var fields = JSON.parse(fields);
                var fs = [];
                for(var key in fields)
                {
                    if(fields[key].type == 'object')
                    {
                        var children = [];
                        var subFields = fields[key].children
                        for(var subKey in subFields)
                        {
                            children.push({value: key + '.' + subKey, label: subFields[subKey].name, name: fields[key].name + '.' + subFields[subKey].name});
                            subFields[subKey].name = fields[key].name + '.' + subFields[subKey].name;
                            that.fieldMap[key + '.' + subKey] = subFields[subKey];
                        }
                        fs.push({value: key, label: fields[key].name, type: fields[key].type, children: children});
                    }
                    else if(fields[key].type == 'option')
                    {
                        var options = [];
                        for(var opKey in fields[key].options)
                        {
                            if(!fields[key].options[opKey]) continue;
                            options.push({value: opKey, label: fields[key].options[opKey], name: fields[key].options[opKey], type: fields[key].type});
                        }
                        fields[key].optionMap = fields[key].options;
                        fields[key].options = options;
                        fs.push({value: key, label: fields[key].name, name: fields[key].name, type: fields[key].type, options: options});
                        that.fieldMap[key] = fields[key];
                    }
                    else
                    {
                        fs.push({value: key, label: fields[key].name, name: fields[key].name, type: fields[key].type});
                        that.fieldMap[key] = fields[key];
                    }
                }
                for(var key in that.settings)
                {
                    that.$delete(that.settings, key);
                }
                that.fields = fs;
            })
        },
        save() {
            var that = this;
            $.post(createLink('chart', 'design', 'chartID=' + this.chart.id), {
                name: that.chart.name,
                type: that.chart.type,
                dataset: that.chart.dataset,
                settings: JSON.stringify(that.settings),
            },function(data) {
                window.location.href = createLink('chart', 'browse');
            })
        },
        loadFilterMap() {
            var fieldsMap = {};

            var fs = [];
            for(var key in filters['option'])
            {
                fs.push({value: key, label: filters['option'][key].name});
                fieldsMap[key] = filters['option'][key];
                var options = [];
                for(var index in filters['option'][key].options)
                {
                    options.push({value: index, label: filters['option'][key].options[index]});
                }
                fieldsMap[key].options = options;
            }
            this.optionFields = fs;

            fs = [];
            for(var key in filters['date'])
            {
                fs.push({value: key, label: filters['date'][key].name});
                fieldsMap[key] = filters['date'][key];
            }
            //this.dateFields = fs;
            this.fieldsMap = fieldsMap;
            for(let i in this.filters) {
                if(typeof this.filters[i].name === 'undefined') this.filters[i].name = this.fieldsMap[this.filters[i].field].name;
            }
        },
    }
})
