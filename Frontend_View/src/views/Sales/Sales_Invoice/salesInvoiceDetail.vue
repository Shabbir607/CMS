
<template>
    <div class="header">
        <div class="headerinfo">
            <div class="headertype">
                <h3>Sales Details</h3>
            </div>
        </div>
    </div>
    <div class="card my-3">
        <div class="card-body">
            <div class="print">
                <span>Sales Detail: {{ otherDetails.inv_no }}</span>
                <span style="cursor: pointer;" @click="downloadPDF"><i class="fa-solid fa-print mx-2"
                        style="font-size: 20px;"></i>Print</span>
            </div>
            <hr>

            <div id="PrintDiv">
                <div class="invoice-box table-height"
                    style="max-width: 1600px;width:100%;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <td style="width:50%;padding:5px;vertical-align:top;text-align:left;">
                                    
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;">
                                            {{userName}}</font>
                                    </font><!--!--><br>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            {{userEmail}}</font>
                                    </font>
                                </td>

                                <td style="width:50%;padding:5px;vertical-align:top;text-align:right;">
                                    <font style="vertical-align: inherit;margin-bottom:25px;">
                                        <font
                                            style="vertical-align: inherit;font-size:14px;color:#9D568A;font-weight:600;line-height: 35px;font-size:28pt; ">
                                            Tax Invoice</font>
                                    </font><!--!--><br>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">#
                                            {{ otherDetails.inv_no }}</font>
                                    </font>
                                </td>
                            </tr><!--!-->
                            <tr>
                                <td style="width:50%;padding:5px;vertical-align:top;text-align:left;">
                                    <font
                                        style="vertical-align: inherit;font-size:14px;color:#9D568A;font-weight:600;line-height: 35px; ">
                                        Bill To</font><!--!--><br>
                                    <font v-if="otherDetails.customer" style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 600;">
                                    {{ otherDetails.customer.name }}</font><!--!--><br>
                                    <font v-if="otherDetails.customer" style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                        {{ otherDetails.customer.email }}</font><!--!--><br>
                                    <font v-if="otherDetails.location" style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                        {{ otherDetails.location.name }}</font><!--!--><br>
                                    <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                         </font><!--!--><br>
                                </td><!--!-->
                                <td style="width:50%;padding:5px;vertical-align:top;text-align:right;"><!--!--><br>
                                    <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                        Invoice Date: {{ otherDetails.invoice_date }}</font><!--!--><br>
                                    <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">Due
                                        Date: {{ otherDetails.due_date }}</font>
                                </td>
                            </tr>
                        </tbody>
                    </table><!--!-->

                    <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
                        <tbody>
                            <tr class="heading " style="background: #404040;">
                                <th
                                    style="width:60%;vertical-align: middle;font-weight: 600;color: #ffffff;font-size: 14px;">
                                    Product</th>
                                <th
                                    style="width:12%;vertical-align: middle;font-weight: 600;color: #ffffff;font-size: 14px;">
                                    QTY</th>
                                <th
                                    style="width:12%;vertical-align: middle;font-weight: 600;color: #ffffff;font-size: 14px;">
                                    Rate</th>
                                <th
                                    style="width:16%;vertical-align: middle;font-weight: 600;color: #ffffff;font-size: 14px;">
                                    Amount</th>
                            </tr>
                            <tr v-for="item in stockDetails" :key="item.id" style="border-top: 1px solid rgb(219, 217, 217);">
                                <td>{{ item.product.name }}</td>
                                <td>{{ item.quantity }}</td>
                                <td>{{ item.rate }}</td>
                                <td>{{ item.amount }}</td>
                            </tr>
                            <tr style="border-top: 1px solid rgb(219, 217, 217);">
                                <td></td>
                                <td></td>
                                <td style="font-weight: bold;">Total:</td>
                                <td style="font-weight: bold;">{{ otherDetails.total_value }}</td>
                            </tr>
                        </tbody>
                </table><br><br><br><br><br>
            </div><!--!-->
            <table class="w-100">
                <tr class="w-50">
                    <td style="padding-top:10px;"><!--!-->
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;font-size: 15px;color:#000;font-weight: 700;"> Terms
                                and Conditions </font>
                        </font><br>
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;font-size: 15px;color:#000;font-weight: 400;">
                                {{ otherDetails.terms_condition }}</font>
                        </font><br>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div></template>


<script>
import axios from 'axios';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import { format } from 'date-fns';

export default {
    name: 'StockTransferDetail',
    data() {
        return {
            stockDetails: '',
            otherDetails: {},
            userName: '',
            userEmail: '',
        }
    },
    methods: {
        async dataFetch() {
            try{
            const response = await axios.get(`api/saleinvoice/detail/${this.$route.params.id}`);
            this.stockDetails = response.data.product;
            this.otherDetails = response.data.data;

            console.log(response)

            const formattedDate = format(new Date(this.otherDetails.invoice_date), 'dd-MMM-yyyy');
            this.otherDetails.invoice_date = formattedDate;
            const formattedDate2 = format(new Date(this.otherDetails.due_date), 'dd-MMM-yyyy');
            this.otherDetails.due_date = formattedDate2;
            }catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },

        async downloadPDF() {
            const pdfElement = document.getElementById('PrintDiv');

            // Use html2canvas to capture the content as an image
            const canvas = await html2canvas(pdfElement);

            // Configuration for jsPDF
            const pdfOptions = {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait',
            };

            // Create a new jsPDF instance
            const doc = new jsPDF(pdfOptions);

            // Configure the imageSmoothingEnabled property for the PDF
            doc.context2d.imageSmoothingEnabled = false;

            // Calculate the width and height of the image on the PDF
            const imgWidth = 190;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            // Add the captured image to the PDF
            doc.addImage(canvas, 'PNG', 10, 10, imgWidth, imgHeight);

            // Save the PDF with a specified filename
            doc.save('Sales Invoice.pdf');
        },
    },
    mounted() {
        this.dataFetch()

        const storedUser = localStorage.getItem('user');

        if (storedUser) {
            const user = JSON.parse(storedUser);
            this.userName = user.name;
            this.userEmail = user.email;
        }


    }
}
</script>

<style scoped>.print {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
th {
    background-color: black;
}
td {
    background-color: white;
}
td,
th {
    border: none;
}</style>