<?php
/**
 * The design view file of chart of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     chart
 * @version     $Id: browse.html.php 5096 2013-07-11 07:02:43Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php js::import($jsRoot . "moment/moment.min.js");?>
<?php js::set('chartConfig', $this->config->chart->settings);?>
<?php js::set('fields', $fields);?>
<?php js::set('datasets', $datasets);?>
<?php js::set('lang', $lang->chart);?>
<?php js::set('chart', $chart);?>
<?php js::set('filters', $filters);?>
<?php js::import($jsRoot . 'vue/vue.js');?>
<?php js::import($jsRoot . 'vue/antd.min.js');?>
<?php js::import($jsRoot . 'echarts/echarts.common.min.js');?>
<?php css::import($jsRoot . "vue/antd.min.css");?>
<?php js::set('sysOptions', $sysOptions);?>
<?php js::set('defaults', $defaults);?>
<template>
<div id="mainMenu" class="clearfix">
  <div class="btn-toolbar pull-left">
    <?php echo html::a(inLink('browse'), "<i class='icon icon-back icon-sm'>$lang->goback</i>", '', 'class="btn"');?>
    <div class="divider"></div>
    <div class="page-title"><span class="text"><?php echo $chart->name;?></span></div>
  </div>
  <div class="btn-toolbar pull-right">
    <button type="submit" id="submit" @click="save" data-placement="bottom" class="btn btn-primary"><?php echo $lang->save;?></button>
  </div>
</div>
<div id="mainContent" class="main-row">
  <div class="side-col" id="sidebar">
    <div class="cell">
      <div id="control">
        <div class="item">
          <p><?php echo $lang->chart->name;?></p>
          <a-input v-model:value="chart.name" placeholder="" class="form-control"/>
        </div>
        <div class="item" v-if="showDataset">
          <p><?php echo $lang->chart->dataset;?></p>
          <a-select v-model:value="chart.dataset" :options="datasets" placeholder="" class="form-control" @change="changeDataset"/>
        </div>
        <div class="item">
          <p><?php echo $lang->chart->type;?></p>
          <a-select v-model:value="chart.type" :options="types" placeholder="" @change="changeType" class="form-control"/>
        </div>
        <div class="border"></div>
        <div v-for="(conf, key) in config[chart.type]" :key="key" class="item">
          <div v-if="conf.type=='select'">
            <div class="control-title">
              <p>{{lang[key]}}</p>
              <button v-if="conf.multiple"><i class="icon-plus" @click="popoverSelect(key)"></i></button>
            </div>
            <a-popover :title="lang.add + lang.group" :visible="show[key]" trigger="click"  placement="right">
              <template slot="content">
                <p>{{lang[key]}}</p>
                <a-select v-model:value="select.field" option-label-prop="name" onChange="this.current.blur" placeholder="" class="form-control">
                  <a-select-option v-for="(field, key2) in fields" v-if="field.type !== 'object'" :name="field.name" :key="field.value">{{field.label}}</a-select-option>
                  <a-select-opt-group v-for="(field, key3) in fields" v-if="field.type === 'object'" :key="key3">
                    <span slot="label">{{field.label}}</span>
                    <a-select-option v-for="(subField, subKey) in field.children" :name="subField.name" :key="subField.value">{{subField.label}}</a-select-option>
                  </a-select-opt-group>
                </a-select>
                <a-radio-group class="item" v-if="select.field && ['date', 'datetime'].indexOf(fieldMap[select.field].type) !== -1" v-model:value="select.dateGroup" :options="dates"></a-radio-group>
                <p>{{lang.display}}</p>
                <a-input v-model:value="select.name" placeholder="" class="form-control"></a-input>
                <div class="pop-bottom">
                  <a-button @click="hide(key)">{{lang.cancel}}</a-button>
                  <a-button @click="saveSelect(key)"type="primary">{{lang.save}}</a-button>
                </div>
              </template>
              <div v-if="typeof settings[key] == 'undefined' || settings[key].length == 0" class="select-box form-control">
                <div @click="popoverSelect(key)" class="select-inner"><i class="icon icon-plus"></i> {{lang.add}}{{lang[key]}}</div>
              </div>
              <div v-else class="select-box form-control">
                <div v-for="(setting, index) in settings[key]" class="select-inner" :key="key">
                  <div class='close' @click="deleteSetting(key, index)"><i class="icon-close"></i></div>
                  <div class='name' @click="popoverSelect(key, index)">{{setting.name ? setting.name : fieldMap[setting.field].name}}</div>
                  <div class='pop' @click="popoverSelect(key, index)"><i class="icon-angle-right"></i></div>
                </div>
              </div>
            </a-popover>
          </div>
          <div v-else-if="conf.type=='time'">
            <div class="control-title">
              <p>{{lang[key]}}</p>
              <button v-if="config[chart.type][key].multiple"><i class="icon-plus" @click="popoverDate(key)"></i></button>
            </div>
            <a-popover :title="lang.add + lang.group" :visible="show[key]" trigger="click"  placement="right">
              <template slot="content">
                <p>{{lang[key]}}</p>
                <a-select v-model:value="date.field" option-label-prop="name" onChange="this.current.blur" placeholder="" class="form-control">
                  <a-select-option v-for="(field, key2) in fields" v-if="field.type !== 'object' && ['date', 'datetime'].indexOf(field.type) !== -1" :name="field.name" :key="field.value">{{field.label}}</a-select-option>
                  <a-select-opt-group v-for="(field, key3) in fields" v-if="field.type === 'object'" :key="key3">
                    <span slot="label">{{field.label}}</span>
                    <a-select-option v-for="(subField, subKey) in field.children" v-if="['date', 'datetime'].indexOf(subField.type) !== -1" :name="subField.name" :key="subField.value">{{subField.label}}</a-select-option>
                  </a-select-opt-group>
                </a-select>
                <p>{{lang.display}}</p>
                <a-input v-model:value="date.name" placeholder="" class="form-control"></a-input>
                <p>{{lang.group}}</p>
                <a-radio-group v-model="date.group" :options="dates"></a-radio-group>
                <div class="pop-bottom">
                  <a-button @click="hide(key)">{{lang.cancel}}</a-button>
                  <a-button @click="saveDate(key)"type="primary">{{lang.save}}</a-button>
                </div>
              </template>
              <div v-if="typeof settings[key] == 'undefined' || settings[key].length == 0" class="select-box form-control">
                <div @click="popoverDate(key)" class="select-inner"><i class="icon icon-plus"></i> {{lang.add}}{{lang[key]}}</div>
              </div>
              <div v-else class="select-box form-control">
                <div v-for="(setting, index) in settings[key]" class="select-inner" :key="key">
                  <div class='close' @click="deleteSetting(key, index)"><i class="icon-close"></i></div>
                  <div class='name' @click="popoverDate(key, index)">{{setting.name ? setting.name : fieldMap[setting.field].name}}</div>
                  <div class='pop' @click="popoverDate(key, index)"><i class="icon-angle-right"></i></div>
                </div>
              </div>
            </a-popover>
          </div>
          <div class="" v-else>
            <div class="control-title">
              <p :class="config[chart.type][key].required ? 'required' : ''">{{lang[key]}}</p>
              <button v-if="config[chart.type][key].multiple"><i class="icon-plus" @click="popoverFormula(key)"></i></button>
            </div>
            <a-popover :title="lang.add + lang[key]" :visible="show[key]" trigger="click" placement="right">
              <template slot="content">
                <a-tabs :active-key="formula.valOrAgg == 'value' ? 'value' : 'agg'" :animated="false" @change="changeTab">
                  <a-tab-pane key="value" :tab="lang.value">
                    <a-select v-model:value="formula.field" option-label-prop="name" @change="changeField(key)" placeholder="" class="form-control">
                      <a-select-option v-for="(field, key2) in fields" v-if="field.type !== 'object'" :name="field.name" :key="field.value">{{field.label}}</a-select-option>
                      <a-select-opt-group v-for="(field, key3) in fields" v-if="field.type === 'object'" :key="key3">
                        <span slot="label">{{field.label}}</span>
                        <a-select-option v-for="(subField, subKey) in field.children" :name="subField.name" :key="subField.value">{{subField.label}}</a-select-option>
                      </a-select-opt-group>
                    </a-select>
                    <p>{{lang.display}}</p>
                    <a-input v-model:value="formula.name" placeholder="" class="form-control"></a-input>
                    <p v-if="fieldMap[formula.field] && fieldMap[formula.field].type == 'date'"><a-checkbox :checked="formula.format == 'pastDays'" @change="changePastDays">{{lang.pastDays}}</a-checkbox></p>
                    <div class="pop-bottom">
                      <a-button @click="hide(key)">{{lang.cancel}}</a-button>
                      <a-button @click="saveFormula(key)"type="primary">{{lang.save}}</a-button>
                    </div>
                  </a-tab-pane>
                  <a-tab-pane key="agg" :tab="lang.agg">
                    <a-select v-model:value="formula.field" option-label-prop="name" @change="changeField(key)" placeholder="" class="form-control">
                      <a-select-option v-for="(field, key2) in fields" v-if="field.type !== 'object'" :name="field.name" :key="field.value">{{field.label}}</a-select-option>
                      <a-select-opt-group v-for="(field, key3) in fields" v-if="field.type === 'object'" :key="key3">
                        <span slot="label">{{field.label}}</span>
                        <a-select-option v-for="(subField, subKey) in field.children" :name="subField.name" :key="subField.value">{{subField.label}}</a-select-option>
                      </a-select-opt-group>
                    </a-select>
                    <p v-if="chart.type == 'table' && fieldMap[formula.field] && fieldMap[formula.field].type == 'option'"><a-checkbox :checked="formula.split" @change="changeSplit">{{lang.split}}</a-checkbox></p>
                    <p>{{lang.agg}}</p>
                    <a-select v-model:value="formula.valOrAgg" :options="aggs" class="form-control"></a-select>
                    <p>{{lang.display}}</p>
                    <a-input v-model:value="formula.name" placeholder="" class="form-control"></a-input>
                    <div class="pop-bottom">
                      <a-button @click="hide(key)">{{lang.cancel}}</a-button>
                      <a-button @click="saveFormula(key)"type="primary">{{lang.save}}</a-button>
                    </div>
                  </a-tab-pane>
                </a-tabs>
              </template>
              <div v-if="typeof settings[key] == 'undefined' || settings[key].length == 0" class="select-box form-control">
                <div @click="popoverFormula(key)" class="select-inner"><i class="icon icon-plus"></i> {{lang.add}}{{lang[key]}}</div>
              </div>
              <div v-else class="select-box form-control">
                <div v-for="(setting, index) in settings[key]" class="select-inner" :key="key">
                  <div class='close' @click="deleteSetting(key, index)"><i class="icon-close"></i></div>
                  <div class='name' @click="popoverFormula(key, index)">{{setting.name ? setting.name : (setting.valOrAgg == 'value' ? fieldMap[setting.field].name : setting.valOrAgg.toUpperCase() + '(' + fieldMap[setting.field].name + ')')}}</div>
                  <div class='pop' @click="popoverFormula(key, index)"><i class="icon-angle-right"></i></div>
                </div>
              </div>
            </a-popover>
          </div>
        </div>
        <div class="item">
          <div class="control-title">
            <p>{{lang.filter}}</p>
            <button><i class="icon-plus" @click="popoverFilter()"></i></button>
          </div>
          <a-popover :title="lang.add + lang.filter" :visible="show.filter" trigger="click"  placement="right">
            <template slot="content">
              <p>{{lang.field}}</p>
              <a-select v-model:value="filter.field" option-label-prop="name" @change="changeFilter" placeholder="" class="form-control">
                <a-select-option v-for="(field, key2) in fields" v-if="field.type !== 'object'" :name="field.name" :key="field.value">{{field.label}}</a-select-option>
                <a-select-opt-group v-for="(field, key3) in fields" v-if="field.type === 'object'" :key="key3">
                  <span slot="label">{{field.label}}</span>
                  <a-select-option v-for="(subField, subKey) in field.children" :name="subField.name" :key="subField.value">{{subField.label}}</a-select-option>
                </a-select-opt-group>
              </a-select>
              <p>{{lang.operator}}</p>
              <a-select v-model:value="filter.operator" @change="changeFilter" :options="operators" class="form-control"></a-select>
              <p v-if="filter.field && ['null', 'notnull'].indexOf(filter.operator) === -1">{{lang.filterValue}}</p>
              <div v-if="filter.field && ['in', 'notin'].indexOf(filter.operator) !== -1">
                <a-select v-if="fieldMap[filter.field].type == 'option'" mode="multiple" :options="fieldMap[filter.field].options" v-model:value="filter.value || undefined" placeholder="" class="form-control"></a-select>
                <a-input v-else v-model:value="filter.value" placeholder="" class="form-control"></a-input>
              </div>
              <div v-else-if="!filter.field || ['null', 'notnull'].indexOf(filter.operator) !== -1"></div>
              <div v-else>
                <a-select v-if="fieldMap[filter.field].type == 'option'" :options="fieldMap[filter.field].options" v-model:value="filter.value" placeholder="" class="form-control"></a-select>
                <a-input v-else v-model:value="filter.value" placeholder="" class="form-control"></a-input>
              </div>
              <div class="pop-bottom">
                <a-button @click="hide('filter')">{{lang.cancel}}</a-button>
                <a-button @click="saveFilter()"type="primary">{{lang.save}}</a-button>
              </div>
            </template>
            <div v-if="typeof settings.filter == 'undefined' || settings.filter.length == 0" class="select-box form-control">
              <div @click="popoverFilter()" class="select-inner"><i class="icon icon-plus"></i> {{lang.add}}{{lang.filter}}</div>
            </div>
            <div v-else class="select-box form-control">
              <div v-for="(setting, index) in settings.filter" class="select-inner" :key="index">
                <div @click="deleteSetting('filter', index)" class='close'><i class="icon-close"></i></div>
                <div @click="popoverFilter(index)" v-if="['null', 'notnull'].indexOf(setting.operator) !== -1" class='name'>{{fieldMap[setting.field].name + ' ' + lang.operatorList[setting.operator]}}</div>
                <div @click="popoverFilter(index)" v-else class='name'>{{fieldMap[setting.field].name + ' ' + lang.operatorList[setting.operator] + ' ' + showField(setting.field, setting.value)}}</div>
                <div @click="popoverFilter(index)" class='pop'><i class="icon-angle-right"></i></div>
              </div>
            </div>
          </a-popover>
        </div>
        <div v-if="this.chart.type !== 'line'" class="border"></div>
        <!--div v-if="this.chart.type !== 'line'" class="item">
          <div class="control-title">
            <p>{{lang.orderby}}</p>
            <button><i class="icon-plus" @click="popoverOrder()"></i></button>
          </div>
          <a-popover :title="lang.add + lang.order" :visible="show.order" trigger="click"  placement="rightBottom">
            <template slot="content">
              <p>{{lang.field}}</p>
              <a-select v-model:value="order.value" :options="orders" placeholder="" class="form-control"></a-select>
              <p>{{lang.orderby}}</p>
              <a-radio-group v-model="order.sort">
                <a-radio value="desc">{{lang.orderList.desc}}</a-radio>
                <a-radio value="asc">{{lang.orderList.asc}}</a-radio>
              </a-radio-group>
              <div class="pop-bottom">
                <a-button @click="hide('order')">{{lang.cancel}}</a-button>
                <a-button @click="saveOrder()"type="primary">{{lang.save}}</a-button>
              </div>
            </template>
            <div v-if="typeof settings.order == 'undefined' || settings.order.length == 0" class="select-box form-control">
              <div @click="popoverOrder()" class="select-inner"><i class="icon icon-plus"></i> {{lang.add}}{{lang.order}}</div>
            </div>
            <div v-else class="select-box form-control">
              <div v-for="(setting, index) in settings.order" class="select-inner" :key="index">
                <div @click="deleteSetting('order', index)" class='close'><i class="icon-close"></i></div>
                <div @click="popoverOrder(index)" v-if="['null', 'notnull'].indexOf(setting.operator) !== -1" class='name'>{{fieldMap[setting.field].name + ' ' + lang.operatorList[setting.operator]}}</div>
                <div @click="popoverOrder(index)" v-else class='name'><i :class="setting.sort == 'desc' ? 'icon-arrow-down' : 'icon-arrow-up'"></i>{{orderMap[setting.value].label}}</div>
                <div @click="popoverOrder(index)" class='pop'><i class="icon-angle-right"></i></div>
              </div>
            </div>
          </a-popover>
        </div-->
      </div>
    </div>
  </div>
  <div class="main-col">
    <div class="chart cell">
      <div class="runbox" v-if="!updated">
        <div class="run">
          <p> {{runError}} </p>
          <button class="btn btn-info" @click="run">{{lang.run}}</button>
        </div>
      </div>
      <div class="chart-container" :style="{'z-index': updated ? 1001 : 0}">
        <div v-if="filters.length > 0" class="filter-container">
          <div v-for="(filter, index) in filters" class="filter">
            <div v-if="filter.type == 'select'" class="input-group">
              <span v-if="filter.name != ''" class="input-group-addon text-ellipsis" :title="filter.name">{{filter.name}}</span>
              <a-select :mode="filter.multiple == 1 ? 'multiple' : ''" v-model:value="filterValues[filter.field]" :style="{width: fieldsMap[filter.field].type == 'option' ? (filter.multiple ? '280px' : '150px') : '250px'}" :options="fieldsMap[filter.field].type == 'option' ? fieldsMap[filter.field].options : sysOptions[fieldsMap[filter.field].type]" placeholder="" class="form-control" @change="changeChartFilter" />
            </div>
            <div v-else-if="filter.type == 'date'" class="input-group">
              <span v-if="filter.name != ''" class="input-group-addon text-ellipsis" :title="filter.name">{{filter.name}}</span>
              <a-date-picker v-model:value="moment()" :style="{width: '200px'}" placeholder="" class="form-control" @change="changeFilter"/>
            </div>
            <div v-else-if="filter.type == 'dateRange'" class="input-group">
              <span v-if="filter.name != ''" class="input-group-addon text-ellipsis" :title="filter.name">{{filter.name}}</span>
              <a-range-picker :placeholder="[lang.begin, lang.end]" :style="{width: '200px'}" class="form-control" @change="changeFilter"/>
            </div>
          </div>
        </div>
        <div v-if="chart.type == 'table'" class="chart-box">
          <a-table :columns="chartData.columns" :data-source="chartData.source" :pagination="false" bordered></a-table>
        </div>
        <div v-else-if="chart.type.indexOf('Report') !== -1" class="report-box" id="report"></div>
        <div v-else class="chart-box" id="draw"></div>
      </div>
    </div>
  </div>
</div>
</template>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
