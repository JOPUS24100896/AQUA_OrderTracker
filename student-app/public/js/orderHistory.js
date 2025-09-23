const table = document.getElementById("table_history");


    let span_count = 0;
    arr.forEach(row => {
        const ColID = document.getElementsByClassName("OrderID" + row);
        const ColDate = document.getElementsByClassName("OrderDate" + row);
        const ColPrice = document.getElementsByClassName("OrderPrice" + row);
        const ColStat = document.getElementsByClassName("OrderStat" + row);

        console.log(ColID);
        console.log("OrderID" + row)
        if(span_count == 0){
            span_count = ColID.length - 1;
            ColID[0].rowSpan = span_count + 1;
            ColDate[0].rowSpan = span_count + 1;
            ColPrice[0].rowSpan = span_count + 1;
            ColStat[0].rowSpan = span_count + 1;
        }else{
            ColID[ColID.length - span_count].remove();
            ColDate[ColDate.length - span_count].remove();
            ColPrice[ColPrice.length - span_count].remove();
            ColStat[ColStat.length - span_count].remove();
            span_count--;
        }        
    });
