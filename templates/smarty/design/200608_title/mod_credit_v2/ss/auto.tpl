<script type="text/javascript" language="javascript">
<!--
{literal}
var cost = null;
var init = null;
var rate = null;
var commis = null;
var edoxod = null;
var evznos = null;
var b_date = null;
var e_date = null;
var counts = null;

function ChangeCur (text) {
		document.getElementById("titleblock").style.display = "none";
		document.getElementById("resblock").style.display = "none";
		document.getElementById("counts0").style.display = "none";
		document.getElementById("counts1").style.display = "none";
		for (var i = 1; i <= 12; i++) {
			if (document.getElementById("val"+i) != null) {
			document.getElementById("val"+i).innerHTML = text;
			}
		}
}

function CheckInt(e, obj) {
	var key;
		e = e || event;
		// для Mozilla - del
		if (e.charCode == 0 && e.keyCode == 46) {
			return true;
		}
		key	= e.charCode || e.keyCode;
		// 46 точка
		// 44 запятая
		// 37, 39 стрелки
		// 8 забой
		// 9 Tab
		// 13 Enter
		// 27 Esc
		if (((key < 48 || key > 57) && key != 9 && key != 8 && key != 13 && key != 27 && key != 37 && key != 39)) {
			return false;
		} else {
			return true;
		}
}
	
function CheckFloat(e, obj) {
	var key;
		e = e || event;
		// для Mozilla - del
		if (e.charCode == 0 && e.keyCode == 46) {
			return true;
		}
		key	= e.charCode || e.keyCode;
		// 46 del и точка 44 запятая
		// 37, 39 стрелки
		if (((key < 48 || key > 57) && key != 46 && key != 44 && key != 8 && key != 9 && key != 13 && key != 27 && key != 37 && key != 39) || (((obj.value.indexOf('.') != -1) || (obj.value.indexOf(',') != -1)) && (key == 46 || key == 44))) {
			return false;
		} else {
			return true;
		}
}

function HideField(id) {
	document.getElementById("titleblock").style.display = "none";
	document.getElementById("resblock").style.display = "none";
	document.getElementById("counts0").style.display = "none";
	document.getElementById("counts1").style.display = "none";
	switch (id) {
		case 0:
			document.frmbase.cost.disabled = true;
			document.frmbase.evznos.disabled = false;
			break;
		case 1:
			document.frmbase.evznos.disabled = true;
			document.frmbase.cost.disabled = false;
			break;
	} 
}

function Round(num, s) {
	var base = Math.pow(10,s);
	return Math.round(num/base)*base;
}

function CountForm() {
	var temp="";
	var err=0;

	document.getElementById("counts0").style.display = "none";
	document.getElementById("counts1").style.display = "none";
	document.getElementById("resblock").style.display = "none";
	cost = document.getElementById("cost");
	init = document.getElementById("pinit");
	b_date = document.getElementById("b_date");
	e_date = document.getElementById("e_date");
	edoxod = document.getElementById("edoxod");
	evznos = document.getElementById("evznos");
	rate = document.getElementById("rate");
	commis = document.getElementById("commis");
	counts = document.getElementById("counts");

	if (!Number(b_date.value) && !err) {
		alert("Укажите \"Срок кредита от\"!");
		err++;
		b_date.focus();
	}
	if (!Number(e_date.value) && !err) {
		alert("Укажите \"Срок кредита до\"!");
		err++;
		e_date.focus();
	}
	if (!Number(cost.value) && Number(counts.value)==1 && !err) {
		alert("Укажите \"Стоимость авто\"!");
		err++;
		cost.focus();
	}
	if (!Number(evznos.value) && !Number(counts.value) && !err) {
		alert("Укажите \"Ежемесячный взнос\"!");
		err++;
		evznos.focus();
	}
	if (!Number(edoxod.value) && !err) {
		alert("Укажите \"Ежемесячный доход\"!");
		err++;
		edoxod.focus();
	}
	if (!Number(rate.value) && !err) {
		alert("Укажите \"Процентную ставку\"!");
		err++;
		rate.focus();
	}  

	if (!err) {
		document.getElementById("titleblock").style.display = "block";
		if (Number(edoxod.value/2) < evznos.value) {
			document.getElementById("err_vznos").style.display = "block";
			document.getElementById("resblock").style.display = "none";
		} else {
			document.getElementById("err_vznos").style.display = "none";
			switch (Number(counts.value)) {
			case 0:
				document.getElementById("counts0").style.display = "block";
				temp = ShowMonthCost();
				temp2 = ShowMonthCostReg();
	        		document.getElementById("resblock").innerHTML = temp + temp2;
				break;
			case 1:
				document.getElementById("credo").innerHTML = FormatNum(Number(cost.value - init.value));
				document.getElementById("counts1").style.display = "block";
				temp = ShowKvartCost();
	        		document.getElementById("resblock").innerHTML = temp;			
				break;
			}
			document.getElementById("resblock").style.display = "block";
		}
	}
}

function ShowMonthCost() {
	var flat_cost = 0;
	var flat_init = Number(init.value);
	var credit = 0;
	var overpay = 0;
	var overpay_percent = 0;
	var temp = "<table border=0 cellspacing=1 cellpadding=3 bgcolor=\"#C6E4E2\"><tr bgcolor=\"#E0F3F3\"><th colspan=\"6\">Аннуитетная схема платежей</th></tr>";
	for (var i = Number(b_date.value); i <= Number(e_date.value); i++) {
		flat_cost = MonthCount(i,flat_init);
		credit = Round(flat_cost - flat_init, 2);
		overpay = Round(12*i*Number(evznos.value) - credit, 2);
 		overpay_percent = Math.round(overpay/credit*100);
   			
   		temp += '<tr bgcolor="#FFFFFF">';
   		temp += "<td width=75>"+i+"</td>";
		temp += "<td  width=150>"+FormatNum(flat_cost)+"</td>";
		temp += '<td  width=90>'+FormatNum(flat_init)+'</td>';
		temp += '<td  width=60>'+FormatNum(credit)+'</td>';
		temp += "<td  width=65>"+FormatNum(overpay)+"</td>";
		temp += "<td width=65>"+overpay_percent+"</td>";
   		temp += "</tr>";
	}  
	temp +="</table>";
	return temp;
} 

function MonthCount(N, C1) {
	var C = Number(evznos.value);
	var P = GetFloat(commis.value)*0.01;
	var R = GetFloat(rate.value)*0.01;
	var S = 0;
	for (var i=1; i <= 12*N; i++) {
		S += 1/Math.pow((1+(R+P)/12),i); 
	}
	S = Round(S*C+C1,3);
	return S;
}

function ShowMonthCostReg() {
	var flat_cost = 0;
	var flat_init = Number(init.value);
	var credit = 0;
	var overpay = 0;
	var overpay_percent = 0;
	var temp = "<table border=0 cellspacing=1 cellpadding=3 bgcolor=\"#C6E4E2\"><tr bgcolor=\"#E0F3F3\"><th colspan=\"6\">Регрессивная схема платежей</th></tr>";
	for (var i = Number(b_date.value); i <= Number(e_date.value); i++) {
		credit = 12*i*Round(evznos.value*(1-commis.value*0.01-rate.value*0.01),3);
		flat_cost = Round(credit + flat_init, 2);
		overpay = MonthCountReg(i);
 		overpay_percent = Math.round(overpay/credit*100);
   			
   		temp += '<tr bgcolor="#FFFFFF">';
   		temp += "<td width=75>"+i+"</td>";
		temp += "<td  width=150>"+FormatNum(flat_cost)+"</td>";
		temp += '<td  width=90>'+FormatNum(flat_init)+'</td>';
		temp += '<td  width=60>'+FormatNum(credit)+'</td>';
		temp += "<td  width=65>"+FormatNum(overpay)+"</td>";
		temp += "<td width=65>"+overpay_percent+"</td>";
   		temp += "</tr>";
	}  
	temp +="</table>";
	return temp;
} 

function MonthCountReg(N) {
	var C = Number(evznos.value);
	var P = GetFloat(commis.value)*0.01;
	var R = GetFloat(rate.value)*0.01;
	var Cp = C*(1-(R+P));
	var S = 0;
	var So = Cp*N*12;
	for (var i=1; i <= 12*N; i++) {
		S += So*(R+P)/(12*N); 
		So -= Cp;
	}
	return Round(S,3);
}
	
function ShowKvartCost() {
	var temp = "<table border=0 cellspacing=1 cellpadding=3 bgcolor=\"#C6E4E2\"><tr bgcolor=\"#E0F3F3\"><th colspan=\"5\">Аннуитетная схема платежей</th></tr>";
	for (var i = Number(e_date.value); i >= Number(b_date.value); i--) {
		var nvalue = KvartCount(i);
		var ivalue = Round(nvalue*2,2);
		var overpay = Round((12*i*Number(nvalue) - Number(cost.value) + Number(init.value)), 2);
		var overpay_percent = Math.round(overpay/(Number(cost.value) - Number(init.value))*100);
   			
		if (ivalue > Number(edoxod.value)) {
			tr = ' bgcolor="#FFFFFF">';
			td = ' title="Расчетный минимальный доход больше введенного вами" ';
		} else {
			tr = ' bgcolor="#FFFFFF">';
			td = '';
		}
		
		temp += '<tr '+tr;
		temp += "<td width=75>"+i+"</td>";
		temp += "<td width=150>"+FormatNum(nvalue)+"</td>";
		temp += '<td width=90'+ td +'>'+FormatNum(ivalue)+'</td>';
		temp += "<td width=65>"+FormatNum(overpay)+"</td>";
		temp += "<td width=65>"+overpay_percent+"</td>";
   		temp += "</tr>";
	}        
	temp +="</table>";
	return temp;
}

function KvartCount(N) {
	var C1 = Number(init.value);
	var P = GetFloat(commis.value)*0.01;
	var R = GetFloat(rate.value)*0.01;
	var S = Number(cost.value);
	var C = 0;
	for (var i=1; i <= 12*N; i++) {
		C += 1/Math.pow((1+(R+P)/12),i); 
	}
	C = Round((S-C1)/C, 1);
	return C;
}

function FormatNum(value) {
		stringValue = new String(value);
		returnValue = '';

		for (var i = stringValue.length,j=0; i >= 0; i--,j++) {
			returnValue = stringValue.charAt(i)+returnValue;
			if (j%3==0&&j!=0) returnValue = ' '+returnValue;
			
		}

		return returnValue;
}

function GetFloat(val) {
	return Number(val.replace(/,/gi, "."));
}
//    -->
{/literal}
</script>
<br/>
			<table cellpadding=0 cellspacing=0 border=0 width=400 bgcolor="#E0F3F3" align="center">
			<tr><td bgcolor="#C6E4E2" align=center class="text11" height=20><b>Расчет суммы автомобильного кредита</b></td></tr>
			<tr>
				<td nowrap>
				<table class=text11 cellpadding=2 cellspacing=0 border=0 align=center>
				<form method=post name="frmbase">
				<input type="hidden" name="cmd" id="cmd" value="search"/>
				<tr>
					<td align=right class=text11>Рассчитать:</td>
					<td colspan="3"><select id="counts" name="counts" class=text11 style="width:270px;" onchange="HideField(this.selectedIndex)">{foreach from=$res.autocount item=l key=k}<option value="{$k}">{$l}</option>{/foreach}</select></td>
				</tr>
				<tr>
					<td align=right class=text11>Cрок кредита от</td>
					<td nowrap  class="text11"><input type=text name="b_date" id="b_date" maxlength=2 size=6 class=text11 value=""  style="width:20px;" onkeypress="return CheckInt(event, this);"> до <input type=text name="e_date" id="e_date" maxlength=2 size=6 class=text11 value=""  style="width:20px;" onkeypress="return CheckInt(event, this);"> лет</td>
					<td align=right class=text11>Валюта</td>
					<td><select id="valute" name="valute" class=text11 style="width:75px;" onchange="ChangeCur(this.options[this.selectedIndex].text)">{foreach from=$res.idval item=l key=k}<option value="{$k}">{$l}</option>{/foreach}</select></td>
				</tr>
				<tr>
					<td align=right class=text11 nowrap>Стоимость авто:</td>
					<td nowrap><input type=text id="cost" name="cost" maxlength=8 size=6 class=text11 value="0"  style="width:50px;" onkeypress="return CheckInt(event, this);" disabled> <span id="val1" class="text11">руб.</span></td>
					<td align=right class=text11 nowrap>Перв. взнос:</td>
					<td nowrap><input type=text id="pinit" name="pinit" maxlength=7 size=6 class=text11 value="0"  style="width:45px;" onkeypress="return CheckInt(event, this);"> <span id="val2" class="text11">руб.</span></td>
				</tr>
				<tr>
					<td align=right class=text11 nowrap>Ежемес. доход:</td>
					<td nowrap><input type=text id="edoxod" name="edoxod" maxlength=7 size=6 class=text11 value="0"  style="width:50px;" onkeypress="return CheckInt(event, this);"> <span id="val3" class="text11">руб.</span></td>
					<td align=right class=text11 nowrap>Ежемес. взнос:</td>
					<td nowrap><input type=text id="evznos" name="evznos" maxlength=7 size=6 class=text11 value="0"  style="width:45px;" onkeypress="return CheckInt(event, this);"> <span id="val4" class="text11">руб.</span></td>
				</tr>
				<tr>
					<td align=right class=text11 nowrap>Проц. ставка:</td>
					<td nowrap  class="text11"><input type=text id="rate" name="rate" maxlength=5 size=6 class=text11 value="0"  style="width:50px;" onkeypress="return CheckFloat(event, this);"> %</td>
					<td align=right class=text11 nowrap>Ежемес. комиссии:</td>
					<td nowrap class="text11"><input type=text id="commis" name="commis" maxlength=4 size=6 class=text11 value="0"  style="width:45px;" onkeypress="return CheckFloat(event, this);"> %</td>
				</tr>
				<tr>
					<td align=center class=text11 colspan=4><input onclick="CountForm();" type="button" value="&nbsp;Рассчитать&nbsp;" class="text11"></td>
				</tr>
				</form>
				</table>
				</td>
			</tr>
			</table>
		<center><div id="titleblock" class="title" style="display:none;"><br/><br/>Результат расчета<br/></div>
		<div id="err_vznos" style="display: none;"><br/><font color=red>Ежемесячный взнос должен составлять не менее 50% от ежемесячного дохода.</font></div>
		<div id="counts0" style="display: none;"><br/>
			<table border=0 cellspacing=1 cellpadding=3 bgcolor="#FFFFFF">
   			<tr bgcolor="#C6E4E2">
	   		<th width=75 class="text11">Срок кредита,<br/>лет</th>
			<th width=150 class="text11">Стоимость авто,<br/><span id="val5">руб.</span></th>
			<th width=90 class="text11">Первонач. взнос,<br/><span id="val6">руб.</span></th>
			<th width=60 class="text11">Кредит,<br/><span id="val7">руб.</span></th>
			<th width=65 class="text11">Переплата в <span id="val8">руб.</span></th>
			<th width=65 class="text11">Переплата в %</th>
   			</tr>			
			</table>
		</div>
		<div id="counts1" style="display: none;"><br/>
			Сумма кредита - <b><span id="credo"></span>&nbsp;<span id="val12">руб.</span></b><br/><br/>
			<table border=0 cellspacing=1 cellpadding=3 bgcolor="#FFFFFF">
			<tr bgcolor="#C6E4E2">
			<th width=75 class="text11">Срок кредита,<br/>лет</th>
			<th width=150 class="text11">Ежемесячный взнос,<br/><span id="val9">руб.</span></th>
			<th width=90 class="text11">Миним. доход,<br/><span id="val10">руб.</span></th>
			<th width=65 class="text11">Переплата в <span id="val11">руб.</span></th>
			<th width=65 class="text11">Переплата в %</th>
   			</tr>			
			</table>
		</div>
		<div id="resblock" style="display: none;"></div>
		</center>
		<br>