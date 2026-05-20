# دليل إعداد GoHighLevel - NAY SPA

## الهيكل الكامل

```
الموقع (Laravel) ←→ GoHighLevel
      ↓                    ↓
 قاعدة البيانات       CRM + WhatsApp + Automations
```

---

## الخطوة 1 — إنشاء Subaccount

1. ادخل إلى GHL Agency Dashboard
2. اضغط **"Add Sub-Account"**
3. أدخل:
   - **Business Name**: NAY SPA
   - **Email**: info@nayspa.iq
   - **Phone**: +964770XXXXXXX
   - **Address**: بغداد، المنصور
4. اضغط **"Save"**

---

## الخطوة 2 — إعداد الـ Calendar (نظام الحجز)

داخل الـ Subaccount:

1. اذهب إلى **Calendars → Create Calendar**
2. اختر نوع **"Round Robin"** أو **"Event"**
3. أعدّ التالي:
   - **Name**: حجوزات NAY SPA
   - **Duration**: 60 دقيقة
   - **Availability**: 10am - 10pm (السبت-الخميس)، 2pm - 10pm (الجمعة)
   - **Buffer Time**: 15 دقيقة بين الحجوزات
4. في **"Booking Page"**:
   - فعّل RTL support
   - أضف نص باللغة العربية
5. احفظ وانسخ **Calendar ID** (ستحتاجه لاحقاً)

---

## الخطوة 3 — إعداد الـ Pipeline (مراحل العميل)

1. اذهب إلى **CRM → Pipelines → Create Pipeline**
2. اسمه: **"مسار الحجوزات"**
3. أضف الـ Stages:
   - 🔵 **حجز جديد** (New Booking)
   - 🟡 **بانتظار التأكيد** (Pending Confirmation)
   - 🟢 **مؤكد** (Confirmed)
   - ✅ **تمت الزيارة** (Completed)
   - ❌ **ملغي** (Cancelled)

---

## الخطوة 4 — إعداد WhatsApp

1. اذهب إلى **Settings → Phone Numbers**
2. اضغط **"Add Phone Number"** → اختر **WhatsApp Business**
3. اربط رقم واتساب المركز (+964...)
4. تحقق من الرقم عبر الكود

**أو استخدم Twilio:**
1. أنشئ حساب Twilio
2. في GHL: Settings → Integrations → Twilio
3. أدخل Account SID + Auth Token
4. فعّل WhatsApp Sandbox

---

## الخطوة 5 — إعداد Workflows (الأتمتة)

### Workflow 1: تأكيد الحجز الفوري

**Trigger**: Contact Created (من الموقع)

**Actions**:
1. ⏱ **Wait**: 0 دقيقة
2. 💬 **Send WhatsApp**: 
   ```
   مرحباً {{contact.first_name}} 🌸
   
   تم استلام طلب حجزك في NAY SPA بنجاح!
   
   📋 تفاصيل الحجز:
   • الخدمة: {{custom_fields.service_name}}
   • التاريخ: {{custom_fields.appointment_date}}
   • الوقت: {{custom_fields.appointment_time}}
   
   سنتواصل معك قريباً للتأكيد النهائي.
   
   شكراً لاختيارك NAY SPA ✨
   ```
3. 📌 **Add Tag**: "new-booking"
4. 🔄 **Move to Pipeline Stage**: "بانتظار التأكيد"

---

### Workflow 2: تأكيد الموعد (من المركز)

**Trigger**: Tag Added = "confirmed"

**Actions**:
1. 💬 **Send WhatsApp**:
   ```
   أهلاً {{contact.first_name}} ✅
   
   تم تأكيد موعدك في NAY SPA!
   
   📅 {{custom_fields.appointment_date}}
   🕐 {{custom_fields.appointment_time}}
   📍 بغداد - المنصور - شارع 14 رمضان
   
   نتطلع لرؤيتك! 🌸
   في حال الرغبة بالتغيير تواصلي معنا:
   📞 +964 770 123 4567
   ```
2. 🔄 **Move Pipeline**: "مؤكد"

---

### Workflow 3: تذكير قبل الموعد (24 ساعة)

**Trigger**: Appointment reminder (24h before)

**Actions**:
1. 💬 **Send WhatsApp**:
   ```
   تذكير بموعدك غداً 🌸
   
   {{contact.first_name}}، نذكّرك بموعدك في NAY SPA
   
   غداً - {{custom_fields.appointment_time}}
   📍 المنصور - شارع 14 رمضان
   
   هل أنت مستعدة؟ نراكِ غداً! ✨
   ```

---

### Workflow 4: متابعة بعد الزيارة (2 يوم)

**Trigger**: Pipeline moved to "تمت الزيارة"
**Wait**: 2 أيام

**Actions**:
1. 💬 **Send WhatsApp**:
   ```
   شكراً لزيارتك NAY SPA 🌸
   
   {{contact.first_name}}، كيف كانت تجربتك معنا؟
   
   ⭐ نتمنى أن تكوني راضية عن خدمتنا
   
   هل تودّين حجز موعدك القادم؟
   👉 [رابط الحجز]
   
   نسعد برؤيتك دائماً 💕
   ```

---

## الخطوة 6 — ربط الموقع مع GHL (Webhook)

### في GHL:
1. اذهب إلى **Settings → Webhooks**
2. أنشئ Webhook جديد:
   - **URL**: `https://your-domain.com/ghl/webhook`
   - **Events**: Contact Created, Appointment Updated

### في Laravel (.env):
```
GHL_API_KEY=your_api_key_here
GHL_LOCATION_ID=your_location_id_here
```

### الحصول على API Key:
1. في GHL → Settings → API Keys
2. اضغط **"Create API Key"**
3. انسخ المفتاح وضعه في .env

### الحصول على Location ID:
1. في GHL → Settings → Business Info
2. انسخ **Location ID**

---

## الخطوة 7 — إعداد الـ Domain

### في GHL:
1. Settings → Domains → Add Domain
2. أدخل: `nayspa.iq` (أو subdomain: `book.nayspa.iq`)
3. أضف DNS records المطلوبة عند مزود الدومين:
   ```
   CNAME: book → ghl-link.com
   ```

### لربط الموقع Laravel بالدومين:
في `.env`:
```
APP_URL=https://nayspa.iq
```

---

## الخطوة 8 — Custom Fields في GHL

أضف هذه الـ Custom Fields في CRM:
1. **service_name** (نص) — اسم الخدمة
2. **appointment_date** (تاريخ) — تاريخ الموعد  
3. **appointment_time** (نص) — وقت الموعد
4. **booking_id** (نص) — رقم الحجز من Laravel
5. **notes** (نص طويل) — ملاحظات

---

## الخطوة 9 — Funnel Pages (اختياري)

إذا أردت صفحات حجز داخل GHL مباشرة:

1. **Funnels → Create Funnel**
2. اختر Template → أو ابنِ من الصفر
3. أضف العناصر:
   - Header مع اللوجو
   - Booking Widget (ربط Calendar)
   - Testimonials Section
   - WhatsApp Button
4. فعّل RTL في إعدادات الصفحة

---

## الخطوة 10 — نموذج SaaS (للبيع لمراكز أخرى)

لجعل هذا النموذج قابلاً للبيع:

### داخل GHL:
1. **Snapshots → Create Snapshot** من الـ Subaccount
2. سمِّه: "NAY SPA Template"
3. يشمل الـ Snapshot:
   - Workflows المُعدّة
   - Pipeline
   - Custom Fields
   - Email/SMS Templates

### للبيع:
- كل عميل جديد = Subaccount جديد
- اضغط **"Load Snapshot"** في الـ Subaccount الجديد
- عدّل الاسم والشعار والهاتف فقط

---

## ملخص التكاليف (تقديري)

| الخدمة | التكلفة الشهرية |
|--------|----------------|
| GHL Agency Plan | $297/شهر (غير محدود) |
| Twilio WhatsApp | ~$20-50/شهر |
| Hosting (Laravel) | $5-20/شهر |
| Domain | $10/سنة |

**إجمالي التكلفة التشغيلية**: ~$330-370/شهر
**سعر البيع لكل مركز**: $100-300/شهر

---

## دعم تقني

لأي استفسار حول الربط:
- GHL Docs: help.gohighlevel.com
- WhatsApp API: developers.facebook.com/docs/whatsapp
