# -*- coding: utf-8 -*-
import time

from peewee import *

#db = SqliteDatabase(app.config['DATABASE'], journal_mode='WAL')
db = MySQLDatabase('vehicle_logo', user='root', passwd='root')


class BaseModel(Model):
    class Meta:
        database = db

    @classmethod
    def get_one(cls, *query, **kwargs):
        # 为了方便使用，新增此接口，查询不到返回None，而不抛出异常
        try:
            return cls.get(*query, **kwargs)
        except DoesNotExist:
            return None

class Carinfo(BaseModel):
    id = IntegerField(primary_key=True)
    passtime = DateTimeField()
    cltx_id = BigIntegerField()
    cltx_hphm = CharField()
    cltx_place = IntegerField()
    cltx_dire = IntegerField()
    cltx_color = IntegerField()
    cltx_lane = IntegerField()
    img_ip = IntegerField()
    img_disk = CharField()
    img_path = CharField()
    hphm = CharField(default='-')
    hpzl = CharField(default='99')
    csys = CharField(default='Z')
    cllx = CharField(default='Q')
    kxd = IntegerField(default=0)
    ppdm = CharField(default='999')
    ppdm2 = CharField(default='999999')
    clpp= CharField(default='其他')
    matchflag = IntegerField(default=1)
    confirmflag = IntegerField(default=1)
    clppflag = IntegerField(default=1)
    smsflag = IntegerField(default=1)

class Carinfo2(BaseModel):
    id = IntegerField(primary_key=True)
    passtime = DateTimeField()
    cltx_id = BigIntegerField()
    cltx_hphm = CharField()
    cltx_place = IntegerField()
    cltx_dire = IntegerField()
    cltx_color = IntegerField()
    cltx_lane = IntegerField()
    img_ip = IntegerField()
    img_disk = CharField()
    img_path = CharField()
    hphm = CharField(default='-')
    hpzl = CharField(default='99')
    csys = CharField(default='Z')
    cllx = CharField(default='Q')
    kxd = IntegerField(default=0)
    ppdm = CharField(default='999')
    ppdm2 = CharField(default='999999')
    clpp= CharField(default='其他')
    matchflag = IntegerField(default=1)
    confirmflag = IntegerField(default=1)
    clppflag = IntegerField(default=1)
    smsflag = IntegerField(default=1)

if __name__ == '__main__':
    s = Carinfo2.get_one(Carinfo2.id == 13363616)
    print s.passtime
    c = Carinfo.insert(passtime=s.passtime,
                       cltx_id=s.cltx_id,
                       cltx_hphm=s.cltx_hphm,
                       cltx_place=s.cltx_place,
                       cltx_dire=s.cltx_dire,
                       cltx_color=s.cltx_color,
                       cltx_lane=s.cltx_lane,
                       img_ip=s.img_ip,
                       img_disk=s.img_disk,
                       img_path=s.img_path,
                       hphm=s.hphm,
                       hpzl=s.hpzl,
                       csys=s.csys,
                       cllx=s.cllx,
                       kxd=s.kxd,
                       ppdm=s.ppdm,
                       ppdm2=s.ppdm2,
                       clpp=s.clpp).execute()

