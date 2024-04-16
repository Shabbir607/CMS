
<template>
    <div class="header">
        <div class="headerinfo">
            <div class="headertype">
                <h3>Purchase Details</h3>
                <h5>View Purchase Details</h5>
            </div>
        </div>
    </div>
    <div class="card my-3">
        <div class="card-body">
            <div class="print">
                <span>Purchase Detail: {{ otherDetails.bill_no }}</span>
                <span style="cursor: pointer;" @click="downloadPDF"><i class="fa-solid fa-print mx-2"
                        style="font-size: 20px;"></i>Print</span>
            </div>
            <hr>

            <div id="PDFinvoice"><!--!-->
                <div style="text-align:center;">
                    <font
                        style="text-align:center;vertical-align: inherit;font-size:16px;color:white;background-color:#9D568A;padding:10px;padding-inline: 60px;font-weight:bold;line-height: 35px; ">
                        Purchase Bill</font><br>
                </div>
                <div class="invoice-box table-height"
                    style="max-width: 1600px;width:100%;overflow: auto;margin:15px auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
                    <table style="width: 100%;line-height: inherit;text-align: left;">
                        <tbody>
                            <tr>
                                <td style="width:36%;padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                    <!--!-->
                                    <font style="vertical-align: inherit;margin-bottom:25px;">
                                        <font
                                            style="vertical-align: inherit;font-size:14px;color:#9D568A;font-weight:600;line-height: 35px; ">
                                            Supplier</font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font v-if="otherDetails.supplier" style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            {{ otherDetails.supplier.name }}</font>
                                    </font><!--!--><br>
                                    <font style="vertical-align: inherit;">
                                        <font v-if="otherDetails.supplier" style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            {{ otherDetails.supplier.email }}</font>
                                    </font><!--!--><br>
                                </td><!--!-->
                                <td style="width:34%;padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                    <!--!-->
                                    <font style="vertical-align: inherit;margin-bottom:25px;">
                                        <font
                                            style="vertical-align: inherit;font-size:14px;color:#9D568A;font-weight:600;line-height: 35px; ">
                                            Company</font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            {{ userName }}</font>
                                    </font><!--!--><br>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            {{ userEmail }}</font>
                                    </font><br>
                                </td>
                                <td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px"><!--!-->
                                    <font style="vertical-align: inherit;margin-bottom:25px;">
                                        <font
                                            style="vertical-align: inherit;font-size:14px;color:#9D568A;font-weight:600;line-height: 35px; ">
                                            Details</font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            No: {{ otherDetails.bill_no }}</font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            Date: {{ otherDetails.invoice_date }}</font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            Reference: {{ otherDetails.reference_no }}</font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font v-if="otherDetails.status === 2" style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            Status: Paid</font>
                                            <font v-else-if="otherDetails.status === 1" style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            Status: Partial</font>
                                            <font v-else style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            Status: UnPaid</font>
                                    </font><br>
                                </td>
                            </tr>
                        </tbody>
                    </table><!--!-->
                    <table class="table" cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
                        <thead>
                            <tr class="heading " style="background: #F3F2F7;">
                                <td
                                    style="width:30%;padding: 5px;vertical-align: middle;font-weight: 600;color: #fafafa; background: #000000;font-size: 14px;padding: 10px; ">
                                    Product Name
                                </td><!--!-->
                                <td
                                    style="width:8%;padding: 5px;vertical-align: middle;font-weight: 600;color: #fafafa; background: #000000;font-size: 14px;padding: 10px; ">
                                    Qty
                                </td>
                                <!--!-->
                                <td
                                    style="width:7%;padding: 5px;vertical-align: middle;font-weight: 600;color: #fafafa; background: #000000;font-size: 14px;padding: 10px; ">
                                    Unit
                                </td>
                                <!--!-->
                                <td
                                    style="width:10%;padding: 5px;vertical-align: middle;font-weight: 600;color: #fafafa; background: #000000;font-size: 14px;padding: 10px; ">
                                    Price
                                </td>
                                <td
                                    style="width:10%;padding: 5px;vertical-align: middle;font-weight: 600;color: #fafafa; background: #000000; font-size: 14px;padding: 10px; ">
                                    Amount
                                </td>
                            </tr>
                        </thead><!--!-->
                        <tbody>
                            <tr v-for="item in stockDetails" :key="item.id" class="details" style="border-top: 1px solid rgb(219, 217, 217);">
                                <td style="padding: 10px;vertical-align: top; display: flex;align-items: center;">{{ item.product.name }}</td>
                                <td style="padding: 10px;vertical-align: top; ">{{ item.quantity }}</td><!--!-->
                                <td style="padding: 10px;vertical-align: top; ">{{ item.product.packing_unit.unit }}</td><!--!-->
                                <td style="padding: 10px;vertical-align: top; ">{{ item.rate }}</td><!--!-->
                                <td style="padding: 10px;vertical-align: top; ">{{ item.amount }}</td>
                            </tr>
                            <tr style="border-top: 1px solid rgb(219, 217, 217);">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="font-weight: bold;">Total:</td>
                                <td style="font-weight: bold;">{{ otherDetails.total_value }}</td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            <table>
                
                <tr>
                    <td>
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;font-size: 15px;color:#000;font-weight: 700;">
                                Description </font>
                        </font><br>
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;font-size: 15px;color:#000;font-weight: 400;">
                                {{ otherDetails.description }}</font>
                        </font><br>
                    </td>
                </tr>
            </table>
            <div class="row" style="margin-top:10px">
                <div class="col-lg-10"><!--!-->
                    <h7>Created by:</h7> <br>
                    <h7 style="font-size:12px;">{{userName}}</h7> <br>
                </div>
            </div>
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
            const response = await axios.get(`api/purchase_invoice/detail/${this.$route.params.id}`);
            this.stockDetails = response.data.product;
            this.otherDetails = response.data.data;

            console.log(response)

            const formattedDate = format(new Date(this.otherDetails.invoice_date), 'dd-MMM-yyyy');
            this.otherDetails.invoice_date = formattedDate;
            }catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },

        async downloadPDF() {
            const pdfElement = document.getElementById('PDFinvoice');

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
            doc.save('data.pdf');
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

td,
th {
    border: none;
}</style>